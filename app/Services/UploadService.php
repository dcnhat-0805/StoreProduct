<?php


namespace App\Services;


class UploadService
{
    public function getFileName($file)
    {
        return $file->getClientOriginalName();
    }

    public function getExtension($file)
    {
        return $file->getClientOriginalExtension();
    }

    public function getFileSize($file)
    {
        return $file->getSize();
    }

    public function getFileType($file)
    {
        return $file->getMimeType();
    }

    public function checkFile($file)
    {
        $type = $this->getFileType($file);
        $size = $this->getFileSize($file);
        $type_image = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];
        if (in_array($type, $type_image)) {
            if ($size <= 1048576) return 1;
            return 0;
        }
        return -1;
    }

    public function deleteFile($fileName, $path)
    {
        if (File::exists($path . '/' . $fileName)) {
            unlink($path . '/' . $fileName);
        }
    }

    public function moveImage($file, $path)
    {
        $fileName = $this->getFileName($file);
        $fileExtension = $this->getExtension($file);
        if ($this->checkFile($file) == 1) {
            $fileName = date('D-m-yyyy') . '-' . rand() . '-' . changeTitle($fileName) . '.' . $fileExtension;
            while (file_exists($path . $fileName)) {
                $fileName = date('D-m-yyyy') . '-' . rand() . '-' . changeTitle($fileName) . '.' . $fileExtension;
            }
            if ($file->move($path, $fileName)) {
                return $fileName;
            }
        }
        return 0;
    }
}
