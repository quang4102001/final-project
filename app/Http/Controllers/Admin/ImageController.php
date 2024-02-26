<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    

    public function index(Request $request)
    {
        $images = Image::query();

        if ($request->SearchImageName) {
            $images->where('name', 'LIKE', '%' . $request->SearchImageName . '%');
        }

        $images = $images->paginate($request->pagination ?? config('admin.pagination', 50))->appends($request->except('_token'));

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
            Log::error($e);
            return response()->json(['error' => 'Delete image successfully.']);
        }
    }

    public function upload(ImageRequest $request)
    {
        try {
            $imageFile = $request->file('image');
            $imageName = time() . '.' . $imageFile->extension();
            $id = Str::uuid();

            // Lưu hình ảnh vào thư mục storage
            $imageFile->storeAs('public/images');

            // Lưu đường dẫn vào cơ sở dữ liệu
            $image = Image::create([
                'id' => $id,    
                'path' => '/storage/images/' . $imageName,
            ]);

            return response()->json([
                'id' => $image->id,
                'path' => asset($image->path),
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
