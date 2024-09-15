<?php

namespace App\Services\Profile;

class ProfileService
{
    public function index()
    {
        return auth()->user()->profile;
    }
}
