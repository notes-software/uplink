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

        $lastID = App::get('database')->insert("users", $register_user, 'Y');

        $driveFolder = "public/assets/drive";
        if (!Filesystem::exists($driveFolder)) {
            Filesystem::makeDirectory($driveFolder);
        }

        $userFolder = "public/assets/drive/{$lastID}";
        if (!Filesystem::exists($userFolder)) {
            Filesystem::makeDirectory($userFolder);
        }

        redirect('/register', ["Success register", "success"]);
    }
}
