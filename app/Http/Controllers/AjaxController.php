<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AjaxController extends Controller
{
    public function destroyMany(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $ids = $request->ids;

                if (!empty($ids)) {
                    Product::whereIn('id', $ids)->delete();
                }

            });
            return response()->json(['success' => 'Delete selected products successfully.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Error destroy many products: ']);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $product = Product::findOrFail($id);

                // Cập nhật thông tin cơ bản của sản phẩm
                $product->update([
                    'status' => $request->input('status'),
                ]);
            });
            return response()->json(['success'=> 'Update status successfully']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Update status failed!']);
        }
    }
}
