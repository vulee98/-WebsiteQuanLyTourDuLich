<?php

namespace App\Helper;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait File
{
    public $public_path = "/public/img/tours";
    public $storage_path = "storage\\img\\tours\\";

    public function file($file, $path, $width, $height): string
    {
        if ($file) {
            $extension       = $file->getClientOriginalExtension();
            $file_name       = $path . '-' . Str::random(30) . '.' . $extension;
            $url             = $file->storeAs($this->public_path, $file_name);
            $public_path     = public_path($this->storage_path . $file_name);
            $img             = Image::make($public_path)->resize($width, $height);
            $url             = preg_replace("/public/", "", $url);
            $img->save($public_path);
            return $file_name;
        }
    }
}
