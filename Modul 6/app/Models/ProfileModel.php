<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    public function getProfile()
    {
        return [
            'nama'  => 'Fadhil Syahdama Mahatma Putra',
            'nim'   => '2410817210026',
            'prodi' => 'Teknologi Informasi',
            'hobi'  => 'Tidur',
            'skill' => 'PHP, C++, HTML, Java, Python',
            'foto'  => 'profile.jpg'
        ];
    }
}