<?php

namespace App\Views\Composers;

use App\Models\Image;
use Illuminate\View\View;

class ImageComposer {
    public function compose (View $view){
        $images = Image::all();

        $view->with('images', $images);
    }
}