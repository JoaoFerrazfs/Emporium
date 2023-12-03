<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

if (!function_exists('saveImage')) {
    function saveImage(Request $request): ?string
    {
        if(!$request->hasFile('image')){
            return  null;
        }

        $extension = $request->image->extension();
        $date = date('Y-m-d-H:i:s');

        $imageName = $request->name . '-' . $date . "." . $extension;
        $fullPath = "images/$imageName";

        Storage::disk('s3')->put($fullPath, file_get_contents($request->file('image')));

        return $fullPath;
    }
}
