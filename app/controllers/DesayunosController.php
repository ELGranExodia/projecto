<?php

    namespace App\Controllers;

    class DesayunosController extends Controller {
        public function index() {
            return $this->view('desayunos');
            
        }
    }