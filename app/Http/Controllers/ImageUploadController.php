<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $image = $request->file('image');
        $name = time() . '.' . strtolower($image->getClientOriginalExtension());
        $path = $image->storeAs('posts', $name, 'product'); // ذخیره در storage/app/public/uploads

        return response()->json(['url' => '/uploads/' . $path]);
    }
}
