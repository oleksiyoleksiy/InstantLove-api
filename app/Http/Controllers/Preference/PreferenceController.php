<?php

namespace App\Http\Controllers\Preference;

use App\Http\Controllers\Controller;
use App\Http\Requests\Preference\PreferenceRequest;
use App\Http\Resources\PreferenceResource;
use App\Http\Resources\PreferenceSuggestionResource;
use App\Http\Resources\ProfileResource;
use App\Models\Preference;
use App\Services\Preference\PreferenceService;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function __construct(private PreferenceService $service) {}

    public function index()
    {
        return PreferenceResource::make($this->service->index());
    }

    public function store(PreferenceRequest $request)
    {
        $data = $request->validated();

        return PreferenceResource::make($this->service->store($data));
    }

    public function update(PreferenceRequest $request, Preference $preference)
    {
        $data = $request->validated();

        return response()->json([
            'preferences' => PreferenceResource::make($this->service->update($preference, $data)),
            'suggestions' => ProfileResource::collection(auth()->user()->suggestions())
        ]);
    }
}
