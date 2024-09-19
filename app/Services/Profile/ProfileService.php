<?php

namespace App\Services\Profile;

use App\Models\Profile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function index()
    {
        return auth()->user()->profile;
    }

    public function store(array $data)
    {
        $images = $this->storeImages($data['images']);

        $profile = auth()->user()->profile()->create([
            'name' => $data['name'],
            'age' => $data['age'],
            'location' => $data['location'],
            'images' => $images,
            'gender' => $data['gender']
        ]);

        return $profile;
    }

    public function update(array $data)
    {
        $profile = auth()->user()->profile;

        $oldImages = explode(',', $profile->images);
        foreach ($oldImages as $oldImage) {
            Storage::delete($oldImage);
        }

        $images = $this->storeImages($data['images']);

        $profile->update([
            'name' => $data['name'],
            'age' => $data['age'],
            'location' => $data['location'],
            'images' => $images,
            'gender' => $data['gender']
        ]);

        return $profile;
    }

    private function storeImages(array $images)
    {
        $imagePaths = array_map(fn($image) => $image->store('images'), $images);
        $imageNames = array_map(fn($path) => explode('/', $path)[1], $imagePaths);
        return implode(',', $imageNames);
    }
}
