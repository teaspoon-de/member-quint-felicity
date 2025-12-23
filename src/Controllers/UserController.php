<?php

class UserController
{
    private function render($view, $vars = []) {
        extract($vars);

        ob_start();
        require __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();
        $pageTitle = "Members";
        $menuActive = "-1";

        require __DIR__ . "/../Views/layout/main.php";
    }

    public function login() {
            $error = null;
            $data = null;
            $pageTitle = "Login";
            require __DIR__ . "/../Views/users/login.php";
    }

    public function loginSubmit() {
        $user = User::get($_POST["username"]);
        if (!$user) {
            $error['message'] = "User nicht gefunden.";
            $error['field'] = 0;
            $data["username"] = $_POST["username"];
            $this->render('users/login', compact('error', 'data'));
        } else if (password_verify($_POST["password"], $user["password"])) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["pw_ini"] = $user["pw_ini"];

            if (isset($_POST["rememberMe"]) && $_POST["rememberMe"] === 'on') {
                $token = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $token);
                User::deleteSessionTokens($user["id"]);
                User::storeSessionToken($user["id"], $tokenHash);
                setcookie('remember_me', $token, time() + 60*60*24*30, '/', '',
                    true,   // Secure
                    true    // HttpOnly
                    );
            }

            header("Location: /songs");
            exit;
        } else {
            $error['message'] = "Falscher Benutzername oder Passwort!";
            $error['field'] = 1;
            $data["username"] = $_POST["username"];
            $this->render('users/login', compact('error', 'data'));
        }
    }

    public function logOut() {
        User::deleteSessionTokens($_SESSION["user_id"]);
        setcookie('remember_me', '', time() - 3600);
        session_destroy();
    }

    public function root() {
        header('Location: /songs');
    }

    public function index() {
        $users = User::all();
        $this->render('users/index', compact('users'));
    }

    public function show() {
        $user = User::find($_SESSION["user_id"]);
        $this->render('users/show', compact('user'));
    }

    public function create() {
        $this->render('users/create');
    }

    public function store() {
        $user = User::get($_POST["username"]);
        if (!$user) {
            User::create($_POST);
            header("Location: /members");
        } else {
            $error = "Username bereits vergeben.";
            $data = $_POST;
            $data['password'] = null;
            $this->render('users/create', compact('error', 'data'));
        }
    }

    public function edit() {
        $user = User::find($_SESSION["user_id"]);
        $error = false;
        $this->render('users/edit', compact('user', 'error'));
    }

    public function update() {
        $error = !User::update($_SESSION["user_id"], $_POST);
        if ($error) {
            $error = "Nutzername existiert bereits.";
            $user = $_POST;
            $this->render("users/edit", compact('user', 'error'));
            return;
        }
        header("Location: /members");
    }

    public function editPassword() {
        $error = false;
        $this->render('users/editPassword', compact('error'));
    }

    public function updatePassword() {
        $user = User::find($_SESSION["user_id"]);

        if (!password_verify($_POST["old"], $user["password"])) {
            $error = "Falsches Passwort.";
            $this->render("users/editPassword", compact('error'));
            return;
        }
        User::updatePassword($_SESSION["user_id"], $_POST['password']);
        header("Location: /members");
    }

    public function delete($id) {
        if ($id == $_SESSION["user_id"]) {
            die("Du kannst dein eigenes Konto nicht löschen.");
        } else {
            User::delete($id);
            header("Location: /members");
        }
    }
}
