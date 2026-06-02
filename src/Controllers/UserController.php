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

    public function confAdmin() {
        $pdo = Database::getConnection();

        // Check if privilege with id or title already exists
        $check = $pdo->prepare("SELECT COUNT(*) FROM privileges WHERE id = ? OR title = ?");
        $check->execute([1, "admin"]);
        if ($check->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO privileges (id, title) VALUES (?, ?)");
            $stmt->execute([1, "admin"]);
        }

        // Ensure user 1 has the admin privilege
        $checkUp = $pdo->prepare("SELECT COUNT(*) FROM user_privileges WHERE user_id = ? AND privilege_id = ?");
        $checkUp->execute([1, 1]);
        if ($checkUp->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO user_privileges (user_id, privilege_id) VALUES (?, ?)");
            $stmt->execute([1, 1]); // Assuming user_id 1 is the admin user
        }
    }

    // TODO: Create standard admin account
    // TODO sql ids beinhalten gelöschte Elemente, das nix gut

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
        $curPrivs = User::getPrivsForUser($_SESSION["user_id"]);
        $this->render('users/index', compact('users', 'curPrivs'));
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

    public function editSelf() {
        $user = User::find($_SESSION["user_id"]);
        $self = true;
        $error = false;
        $this->render('users/edit', compact('user', 'self', 'error'));
    }

    public function edit($id) {
        if ($id == $_SESSION["user_id"]) {
            header("Location: /account/edit");
            return;
        }
        $admin = in_array('admin', User::getPrivsForUser($_SESSION["user_id"]));
        if (!$admin) {
            header("Location: /members");
            return;
        }
        $user = User::find($id);
        $self = false;
        $error = false;
        $this->render('users/edit', compact('user', 'self', 'error'));
    }

    public function updateSelf() {
        $error = !User::update($_SESSION["user_id"], $_POST);
        if ($error) {
            $error = "Nutzername existiert bereits.";
            $user = $_POST;
            $this->render("users/edit", compact('user', 'error'));
            return;
        }
        header("Location: /members");
    }

    public function update($id) {
        $error = !User::update($id, $_POST);
        if ($error) {
            $error = "Nutzername existiert bereits.";
            $user = $_POST;
            $this->render("users/edit", compact('user', 'error'));
            return;
        }
        header("Location: /members");
    }

    public function editPasswordSelf() {
        $self = true;
        $error = false;
        $this->render('users/editPassword', compact('error', 'self'));
    }

    public function editPassword($id) {
        if ($id == $_SESSION["user_id"]) {
            header("Location: /account/edit/password");
            return;
        }
        $admin = in_array('admin', User::getPrivsForUser($_SESSION["user_id"]));
        if (!$admin) {
            header("Location: /members");
            return;
        }
        $user = User::find($id);
        $self = false;
        $error = false;
        $this->render('users/editPassword', compact('user', 'error', 'self'));
    }

    public function updatePasswordSelf() {
        $user = User::find($_SESSION["user_id"]);

        if (!password_verify($_POST["old"], $user["password"])) {
            $self = true;
            $error = "Falsches Passwort.";
            $this->render("users/editPassword", compact('self', 'error'));
            return;
        }
        User::updatePassword($_SESSION["user_id"], $_POST['password']);
        header("Location: /members");
    }

    public function updatePassword($id) {
        if ($id == $_SESSION["user_id"]) {
            header("Location: /account/edit");
            return;
        }
        $admin = in_array('admin', User::getPrivsForUser($_SESSION["user_id"]));
        if (!$admin) {
            header("Location: /members");
            return;
        }
        $user = User::find($id);
        User::updatePassword($id, $_POST['password']);
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
