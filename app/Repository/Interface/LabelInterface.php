<?php

        namespace App\Repository\Interface;

        interface Label
        {
            public function index();
            public function store();
            public function update();
            public function delete();
        }