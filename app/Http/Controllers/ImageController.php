<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    //
    public function upload(ImageRequest $request)
    {
        try {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();

            $uuid = Str::uuid();

            // Lưu hình ảnh vào thư mục storage
            $image->storeAs('public/images', $imageName);

            // Lưu đường dẫn vào cơ sở dữ liệu
            Image::create([
                'id' => $uuid,
                'path' => '/storage/images/' . $imageName,
            ]);

            return response()->json([
                'id' => $uuid,
                'path' => asset('storage/images/' . $imageName),
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->withInput(request()->all())
                ->with('error', 'Error update product: ' . $e->getMessage() . ' ' . $e->getLine());
        }
    }
}
