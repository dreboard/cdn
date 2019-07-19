<?php

namespace App\Main;

use App\Models\File;

class FileController
{
    public function saveFile(array $file_array)
    {
       File::create([]);
    }

    public function getFiles()
    {
        $dir    = $_SERVER['DOCUMENT_ROOT'].'/files/';
        $iterator = new \FilesystemIterator($dir);
    }


}