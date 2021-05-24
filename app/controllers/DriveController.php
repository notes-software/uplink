<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Request;

class DriveController
{
    protected $pageTitle;

    public function index()
    {
        $pageTitle = "Drive";

        return view('/drive/index', compact('pageTitle'));
    }
}
