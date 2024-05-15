<?php

namespace App\Traits;
use App\Models\FileManager;

trait FileUploadTrait
{
    public function FileUpload($file, $originType, $originTd, $folder): void
    {
        $fileManager = new FileManager();
        $fileDetails = $fileManager->fileDataMaping($file, $originType, $originTd, $folder);
        $fileManager->upload($fileDetails);
    }

    public function FileUpdate($newFile, $originType, $originId, $folder): void
    {
        $fileManager = FileManager::where('origin_type', $originType)->where('origin_id', $originId)->get()->first();
        if (!$fileManager) {
            $fileManager = new FileManager();
        }
        $fileDetails = $fileManager->fileDataMaping($newFile, $originType, $originId, $folder);
        $fileDetails['storage_path'] = $fileManager->file_link;
        $fileManager->updateFile($fileDetails);
    }
}
