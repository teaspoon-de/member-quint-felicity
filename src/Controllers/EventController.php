<?php

class EventController {
    private function render($view, $vars = []) {
        extract($vars);

        ob_start();
        require __DIR__ . "/../Views/$view.php";
        $content = ob_get_clean();
        $pageTitle = "Events";
        $menuActive = "2";

        require __DIR__ . "/../Views/layout/main.php";
    }

    public function index() {
        $events = Event::all();
        $this->render('events/index', compact('events'));
    }

    public function show($id) {
        $event = Event::find($id);
        $regs = Event::getRegistrations($id);
        $this->render('events/show', compact('event', 'regs'));
    }

    public function create() {
        $this->render('events/create');
    }

    public function store() {
        Event::create($_POST);
        header("Location: /events");
    }

    public function edit($id) {
        $event = Event::find($id);
        $this->render('events/edit', compact('event'));
    }

    public function update($id) {
        Event::update($id, $_POST);
        header("Location: /events/$id");
    }

    public function register($id) {
        Event::register($id, $_POST);
        header("Location: /events/$id");
    }

    public function delete($id) {
        Event::delete($id);
        header("Location: /events");
    }
}
