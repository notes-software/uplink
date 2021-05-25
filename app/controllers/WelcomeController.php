<?php

namespace App\Controllers;

class WelcomeController
{
    protected $pageTitle;

    public function home()
    {
        $pageTitle = "Home";
        $crumbs = 'Home';

        return view('/home', compact('pageTitle', 'crumbs'));
    }
}
