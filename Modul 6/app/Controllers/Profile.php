<?php

namespace App\Controllers;

use App\Models\ProfileModel;

class Profile extends BaseController
{
    public function index()
    {
        $profileModel = new ProfileModel();

        $data['profile'] = $profileModel->getProfile();

        return view('profile/index', $data);
    }
}