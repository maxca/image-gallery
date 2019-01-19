<?php

use Intervention\Image\Facades\Image;

Route::get('storage/images/{filename}', function ($filename) {
    return Image::make(storage_path('app/images/' . $filename))->response();
});