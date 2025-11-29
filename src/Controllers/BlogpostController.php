<?php

class BlogpostController {
    private function render($view, $vars = []) {
        extract($vars);

        ob_start();
        require __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();

        require __DIR__ . "/../Views/layout/main.php";
    }

    public function index() {
        $blogposts = Blogpost::all();
        $this->render('blogposts/index', compact('blogposts'));
    }

    public function show($id) {
        $blogpost = Blogpost::find($id);
        $this->render('blogposts/show', compact('blogpost'));
    }

    public function create() {
        $this->render('blogposts/create');
    }

    public function store() {
        Blogpost::create($_POST);
        header("Location: /blogposts");
    }

    public function edit($id) {
        $blogpost = Blogpost::find($id);
        $this->render('blogposts/edit', compact('blogpost'));
    }

    public function update($id) {
        Blogpost::update($id, $_POST);
        header("Location: /blogposts");
    }

    public function delete($id) {
        Blogpost::delete($id);
        header("Location: /blogposts");
    }
}
