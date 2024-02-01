<?php

namespace App\Providers\Composers;

use App\Models\Size;
use Illuminate\View\View;

class SizeComposer {
    public function compose (View $view){
        $sizes = Size::all();

        $view->with('sizes', $sizes);
    }
}