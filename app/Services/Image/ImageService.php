<?php

namespace App\Services\Image;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function getImage(string $image)
    {
        $foundImage = Storage::get("images/$image");

        if (empty($foundImage)) {
            abort(404);
        }

        return response($foundImage, 200)->header('Content-Type', 'image');
    }

}
