<?php

namespace Admin\Controller;

class IndexController extends TemplateMustLoginController {

    public function index() {
        $this->redirect('Admin/Manager/student');
    }
}