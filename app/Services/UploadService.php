<?php

namespace App\Services;

use File;

class UploadService
{
    public static function getFileName($file)
    {
        return $file->getClientOriginalName();
    }

    public static function getExtension($file)
    {
        return $file->getClientOriginalExtension();
    }

    public static function getFileSize($file)
    {
        return $file->getSize();
    }

    public static function getFileType($file)
    {
        return $file->getMimeType();
    }

    public static function checkFile($file)
    {
        $type = self::getFileType($file);
        $size = self::getFileSize($file);
        $type_image = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];
        if (in_array($type, $type_image)) {
            if ($size <= (1024 * 1024 * 25)) return 1;
            return 0;
        }
        return -1;
    }

    public static function deleteFile($path, $fileName)
    {
        if (File::exists($path . $fileName)) {
            unlink($path . $fileName);
        }
    }

    public static function moveImage($path, $file, $prefix)
    {
        $fileName = self::getFileName($file);
        $fileExtension = self::getExtension($file);
        if (self::checkFile($file) == 1) {
            $fileName = $prefix . '-' . date('Y-m-d') . '-' . rand() . '.' . $fileExtension;
            while (file_exists($path . $fileName)) {
                $fileName = $prefix . '-' . date('Y-m-d') . '-' . rand() . '-' . $fileExtension;
            }
            if ($file->move($path, $fileName)) {
                return $fileName;
            }
        }

        return 0;
    }

    public static function uploadImage($file)
    {
        if (self::checkFile($file) == 1) {
            return \Storage::putFile('public/product', $file);
        }
        return 0;
    }
}
