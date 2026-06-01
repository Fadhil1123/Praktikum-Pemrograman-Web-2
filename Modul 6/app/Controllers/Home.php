<?php

namespace App\Controllers;

use App\Models\ProfileModel;

class Home extends BaseController
{
    public function index()
    {
        $profileModel = new ProfileModel();

        $data['profile'] = $profileModel->getProfile();

        return view('home/index', $data);
    }
}