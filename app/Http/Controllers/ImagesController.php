<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImagesController extends Controller
{
    const PAGINATION = 50;

    public function index(Request $request)
    {
        $images = Image::query();

        if ($request->SearchImageName) {
            $images->where('name', 'LIKE', '%' . $request->SearchImageName . '%');
        }

        $images = $images->paginate($request->pagination ?? static::PAGINATION)->appends($request->except('_token'));

        return view("admin.images.index", compact('images'));
    }

    public function destroy(string $id)
    {
        try {
            $image = Image::find($id);
            
            DB::transaction(function () use ($image) {
                $image->products()->detach();
                $image->delete();
            });
            
            $this->destroyFromStorage($image->path);

            return response()->json(['success' => 'Delete image successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete image successfully.']);
        }
    }

    public function upload(ImageRequest $request)
    {
        try {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $id = Str::uuid();

            // Lưu hình ảnh vào thư mục storage
            $image->storeAs('public/images', $imageName);

            // Lưu đường dẫn vào cơ sở dữ liệu
            DB::transaction(function () use ($id, $imageName) {
                Image::create([
                    'id' => $id,
                    'path' => '/storage/images/' . $imageName,
                ]);
            });

            return response()->json([
                'id' => $id,
                'path' => asset('storage/images/' . $imageName),
                'success' => 'Uploading image successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error', 'Uploading image failed.']);
        }
    }

    public function destroyFromStorage(string $path)
    {
        $url = str_replace('/storage', 'public', $path);
        Storage::delete($url);
    }
}
