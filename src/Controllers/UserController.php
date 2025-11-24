<?php

class UserController
{
    private function render($view, $vars = [])
    {
        extract($vars);

        ob_start();
        require __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();

        require __DIR__ . "/../Views/layout/main.php";
    }

    public function login()
    {
            $error = false;
            $data = false;
            $this->render('users/login', compact('error', 'data'));
    }

    public function loginSubmit()
    {
        $user = User::get($_POST["username"]);
        if (!$user) {
            $error = "User nicht gefunden.";
            $data["username"] = $_POST["username"];
            $this->render('users/login', compact('error', 'data'));
        } else if (password_verify($_POST["password"], $user["password"])) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $user["id"];
            header("Location: /songs");
            exit;
        } else {
            $error = "Falscher Benutzername oder Passwort!";
            $data["username"] = $_POST["username"];
            $this->render('users/login', compact('error', 'data'));
        }
    }

    public function index()
    {
        $users = User::all();
        $this->render('users/index', compact('users'));
    }

    public function show()
    {
        $user = User::find($_SESSION["user_id"]);
        $this->render('users/show', compact('user'));
    }

    public function create()
    {
        $this->render('users/create');
    }

    public function store()
    {
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

    public function edit()
    {
        $user = User::find($_SESSION["user_id"]);
        $this->render('users/edit', compact('user'));
    }

    public function update()
    {
        User::update($_SESSION["user_id"], $_POST);
        header("Location: /account");
    }

    public function delete($id)
    {
        if ($id == $_SESSION["user_id"]) {
            die("Du kannst dein eigenes Konto nicht löschen.");
        } else {
            User::delete($id);
            header("Location: /members");
        }
    }
}
