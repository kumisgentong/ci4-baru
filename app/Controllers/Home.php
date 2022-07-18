<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function getuser()
    {
        $session = session();
        $user = $session->id_user;
        return $user;
        // $user['id'] = 123;
    }
}