<?php

namespace App\Services\Suggestion;

use App\Models\Profile;

class SuggestionService
{
    public function index()
    {
        return auth()->user()->suggestions();
    }
}
