<?php

namespace App\Services;

use App\Models\User;
use App\Repository\DemoRepo;

class DemoService implements DemoRepo
{
    public function __construct()
    {
    }
    public function disp($id = "")
    {
        $data = User::get();
        return $data;
    }
    public function add()
    {
    }

    public function updt()
    {
    }
}
