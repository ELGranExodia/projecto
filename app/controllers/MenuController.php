<?php

    namespace App\Controllers;

    class MenuController extends Controller {
        public function index() {
            return $this->view('menu');
            
        }
    }