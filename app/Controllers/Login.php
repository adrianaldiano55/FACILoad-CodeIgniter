<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function Login(): string
    {
        return view('login');
    }
}
