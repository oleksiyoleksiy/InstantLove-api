<?php

namespace App\Http\Controllers\Suggestion;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Services\Suggestion\SuggestionService;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function __construct(private SuggestionService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProfileResource::collection($this->service->index());
    }
}
