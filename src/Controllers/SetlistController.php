<?php

class SetlistController {
    private function render($view, $vars = []) {
        extract($vars);

        ob_start();
        require __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();

        switch($view) {
            case "setlists/create":
                $pageTitle = "Setlist erstellen";
                break;
            case "setlists/show":
                $pageTitle = "Setlists - ". $setlist['name'];
                break;
            case "setlists/edit":
                $pageTitle = "Setlist bearbeiten";
                break;
            default:
                $pageTitle = "Setlists";
        }
        $menuActive = "1";

        require __DIR__ . "/../Views/layout/main.php";
    }

    public function index() {
        $setlists = Setlist::all();
        $this->render('setlists/index', compact('setlists'));
    }

    public function show($id) {
        $setlist = Setlist::find($id);
        $items = Setlist::getItems($id);
        $this->render('setlists/show', compact('setlist', 'items'));
    }

    public function create() {
        $this->render('setlists/create');
    }

    public function store() {
        Setlist::create($_POST);
        header("Location: /setlists");
    }

    public function edit($id) {
        $setlist = Setlist::find($id);
        $this->render('setlists/edit', compact('setlist'));
    }

    public function update($id) {
        Setlist::update($id, $_POST);
        header("Location: /setlists/$id");
    }

    public function delete($id) {
        Setlist::delete($id);
        header("Location: /setlists");
    }
}
