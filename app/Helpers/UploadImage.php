<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class UploadImage
{
    /**
     * Handle the image upload process with size validation.
     *
     * @param  Request $request
     * @param  string  $filename
     * @param  string  $existingPath
     * @param  string  $folder
     * @param  int     $maxSize
     * @return string  The image path or URL.
     */
    public static function upload(Request $request, $filename, $existingPath = null, $folder = 'default', $maxSize = 500)
    {
        if ($request->hasFile($filename)) {
            $file = $request->file($filename);

            $validation = self::validateImageSize($file, $maxSize);
            if ($validation['res'] == 'error') {
                return $validation;
            }

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg', 'avif', 'webp'];
            $fileExtension = strtolower($file->getClientOriginalExtension());

            if (!in_array($fileExtension, $allowedExtensions)) {
                return [
                    'res' => 'error',
                    'msg' => 'The file must be of type: JPG, JPEG, PNG, SVG, AVIF, or WEBP.'
                ];
            }

            $newFilename = Str::random(10) . '.' . $file->getClientOriginalExtension();

            $uploadPath = Config::get('app.UPLOAD_PATH').'/' . $folder;

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $path = $file->move($uploadPath, $newFilename);

            if ($existingPath) {
                $existingFile = Config::get('app.DELETE_PATH') . $existingPath;
                if (File::exists($existingFile)) {
                    File::delete($existingFile);
                }
            }

            return [
                'res' => 'success','file_path' => $folder . '/' . $newFilename
            ];
        }

        return [
            'res' => 'success',
            'file_path' => $existingPath ?: Config::get('app.DEFAULT_IMAGE') . 'avatar-4.jpg'
        ];
    }

    /**
     * Validate the image size and type.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  int  $maxSize
     * @return array
     */
    public static function validateImageSize($file, $maxSize)
    {
        $return = [
            'res' => 'error',
            'msg' => 'File size too large!'
        ];
        $fileSize = $file->getSize();
        if ($fileSize > ($maxSize * 1024)) {
            return [
                'res' => 'error',
                'msg' => "The file exceeds the maximum size limit of " . ($maxSize) . " KB."
            ];
        }
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/svg+xml',
            'image/avif',
            'image/webp'
        ];
        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            return [
                'res' => 'error',
                'msg' => 'The file must be of type: jpeg, png, jpg, gif, svg, webp, avif.'
            ];
        }
        return [
            'res' => 'success'
        ];
    }

    public static function deleteFile($filePath)
    {
        if (empty($filePath)) {
            return false;
        }
        $fullPath = config('app.DELETE_PATH') . $filePath;

        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return true;
    }
}
