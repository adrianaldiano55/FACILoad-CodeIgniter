<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function admin()
    {
        return view('admin_dashboard');
    }

    public function staff()
    {
        return view('staff_dashboard');
    }
}