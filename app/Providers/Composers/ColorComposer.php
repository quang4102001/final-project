<?php

namespace App\Providers\Composers;

use App\Models\Color;
use Illuminate\View\View;

class ColorComposer {
    public function compose (View $view){
        $colors = Color::all();

        $view->with('colors', $colors);
    }
}