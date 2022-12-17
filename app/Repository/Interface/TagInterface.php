<?php

        namespace App\Repository\Interface;

        interface Tag
        {
            public function index();
            public function store();
            public function update();
            public function delete();
        }