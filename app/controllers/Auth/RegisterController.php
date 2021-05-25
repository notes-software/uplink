<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Core\Request;
use App\Core\Filesystem;

class RegisterController
{
    protected $pageTitle;

    public function index()
    {
        Auth::isAuthenticated();

        $pageTitle = "Register";
        return view('/auth/register', compact('pageTitle'));
    }

    public function store()
    {
        $request = Request::validate('/register', [
            'email' => ['required', 'email'],
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $register_user = [
            'email' => $request['email'],
            'fullname' => $request['name'],
            'username' => $request['username'],
            'password' => md5($request['password']),
            'updated_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s")
        ];

        $lastID = App::get('database')->insert("users", $register_user . 'Y');

        $dir = "public/assets/drive";
        Filesystem::makeDirectory($dir);

        $dir = "public/assets/drive/{$lastID}";
        Filesystem::makeDirectory($dir);

        redirect('/register', ["Success register", "success"]);
    }
}
