<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('storeImages')) {
    function storeImages($path, $files) {


        $extension = $files->getClientOriginalExtension();
        $imageName = generateImageName($extension);
        $files->storeAs(
            $path, $imageName
        );
        return $imageName;

    }

}


if(!function_exists('generateImageName')) {
    function generateImageName($extension) {
      return preg_replace('/(0)\.(\d+) (\d+)/', '$3$1$2', microtime()).'.'.$extension;
    }
  }
