<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Request;

class NotesController
{
    protected $pageTitle;

    public function index()
    {
        $pageTitle = "Notes";
        $crumbs = 'Notes';

        return view('/notes/index', compact('pageTitle', 'crumbs'));
    }
}
