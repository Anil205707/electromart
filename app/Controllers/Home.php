<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $db->initialize();

            echo "Database connected successfully.";
        } catch (\Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}