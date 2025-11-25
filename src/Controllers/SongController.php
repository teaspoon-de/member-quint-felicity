<?php

class SongController
{
    private function render($view, $vars = [])
    {
        extract($vars);

        ob_start();
        require __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();

        require __DIR__ . "/../Views/layout/main.php";
    }

    public function index()
    {
        $songs = Song::all();
        $this->render('songs/index', compact('songs'));
    }

    public function show($id)
    {
        $song = Song::find($id);
        $this->render('songs/show', compact('song'));
    }

    public function add()
    {
        $this->render('songs/add');
    }
    
    public function store()
    {
        Song::create($_POST);
        header("Location: /songs");
    }

    public function edit($id)
    {
        $song = Song::find($id);
        $this->render('songs/edit', compact('song'));
    }

    public function update($id)
    {
        Song::update($id, $_POST);
        header("Location: /songs/$id");
    }

    public function delete($id)
    {
        Song::delete($id);
        header("Location: /songs");
    }
}
