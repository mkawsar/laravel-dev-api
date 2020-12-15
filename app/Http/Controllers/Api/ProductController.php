<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\UuidGenerateTrait;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    use UuidGenerateTrait;

    public function index()
    {
        $products = Product::with('creator')->paginate(5);
        foreach ($products as $key => $product) {
            if ($product->image !== null) {
                $product->image = config('constant.app.url') . '/images/product/thumb/thumb_96x96_' . $product->image;
            }
        }
        return $products;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_title' => 'required',
            'product_description' => 'required',
            'image' => 'required',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'failed'
            ], 400);
        }

        $imageName = '';

        if ($request->file('image') !== null) {
            $file = $request->file('image');
            $imageName = $this->uuid() . '-' . $file->getClientOriginalName();
            $thumb_96x96 = 'thumb_96x96_' . $imageName;
            $file->move(public_path() . '/images/product/', $imageName);
            $path = public_path() . '/images/product/' . $imageName;
            Image::make($path)->resize(96, 96)->save(public_path() . '/images/product/thumb/' . $thumb_96x96);
        }

        $product = new Product();
        $product->id = $this->uuid();
        $product->creator_id = Auth::user()->id;
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->image = $imageName;
        $product->price = $request->price;

        if ($product->save()) {
            return response([
                'message' => 'Product added successfully.',
                'status' => 'success'
            ]);
        } else {
            return response([
                'message' => 'Failed to new product add.',
                'status' => 'failed'
            ]);
        }
    }

    public function destroy($productID)
    {
        if (Product::where('id', '=', $productID)->delete()) {
            return response([
                'message' => 'Product deleted successfully.',
                'status' => 'success'
            ]);
        } else {
            return response([
                'message' => 'Failed to delete the product.',
                'status' => 'failed'
            ]);
        }
    }

    public function show($productID)
    {
        $product = Product::find($productID);
        if (empty($product)) {
            return response()->json([
                'message' => 'Product not found',
                'status' => 'failed'
            ], 404);
        }
        if ($product->image !== null) {
            $product->image = config('constant.app.url') . '/images/product/' . $product->image;
        }
        return $product;
    }

    public function update(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'product_title' => 'required',
            'product_description' => 'required',
            'price' => 'required'
        ]);

        $product = Product::find($productId);
        if (empty($product)) {
            return response()->json([
                'message' => 'Product not found',
                'status' => 'failed'
            ], 404);
        }

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'failed'
            ], 400);
        }

        $imageName = $product->image;

        if ($request->file('image') !== null) {
            $file = $request->file('image');
            $imageName = $this->uuid() . '-' . $file->getClientOriginalName();
            $thumb_96x96 = 'thumb_96x96_' . $imageName;
            $file->move(public_path() . '/images/product/', $imageName);
            $path = public_path() . '/images/product/' . $imageName;
            Image::make($path)->resize(96, 96)->save(public_path() . '/images/product/thumb/' . $thumb_96x96);
        }

        $payload = [
            'product_title' => $request->product_title,
            'product_description' => $request->product_description,
            'price' => $request->price,
            'image' => $imageName
        ];

        if (Product::where('id', '=', $productId)->update($payload)) {
            return response([
                'message' => 'Product updated successfully.',
                'status' => 'success'
            ]);
        } else {
            return response([
                'message' => 'Failed to update the product.',
                'status' => 'failed'
            ]);
        }
    }
}
