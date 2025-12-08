<?php

class ImageController {
    private function render($view, $vars = []) {
        extract($vars);

        ob_start();
        require __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();

        switch($view) {
            case "images/create":
                $pageTitle = "Bild hochladen";
                break;
            case "images/show":
                $pageTitle = "Bilder - ". $image['title'];
                break;
            case "images/edit":
                $pageTitle = "Bild bearbeiten";
                break;
            default:
                $pageTitle = "Bilder";
        }
        $menuActive = "3";

        require __DIR__ . "/../Views/layout/main.php";
    }

    public function index() {
        $images = Image::all();
        $this->render('images/index', compact('images'));
    }

    public function show($id) {
        $image = Image::find($id);
        $this->render('images/show', compact('image'));
    }

    public function create() {
        $this->render('images/create');
    }

    public function store() {
        Image::create($_FILES);
        header("Location: /blog/images");
    }

    public function edit($id) {
        $image = Image::find($id);
        $this->render('images/edit', compact('image'));
    }

    public function update($id) {
        Image::update($id, $_POST);
        header("Location: /blog/images");
    }

    public function delete($id) {
        Image::delete($id);
        header("Location: /blog/images");
    }
}
