<?php

namespace App\Services;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    /**
     * @param UploadedFile $uploadedFile
     * @param Model $model
     * @return File
     * @throws \Exception
     */
    public function store(UploadedFile $uploadedFile, Model $model): File
    {
        try {
            DB::beginTransaction();

            $name = $this->getFileName($uploadedFile->getClientOriginalName());

            $filePath = $this->getFileStorePath($model);

            Storage::putFileAs('public/'.$filePath, $uploadedFile, $name, 'public');

            $file = new File();
            $file->original_name = $uploadedFile->getClientOriginalName();
            $file->name = $name;
            $file->path = $filePath;
            $file->mime = $uploadedFile->getMimeType();
            $file->fileable()->associate($model);
            $file->save();

            DB::commit();

            return $file;
        } catch (\Exception $exception) {
            $this->revertFileStoreAction($name, $filePath);

            DB::rollBack();

            throw new \Exception($exception);
        }
    }

    /**
     * @param string $originalName
     * @return string
     */
    private function getFileName(string $originalName): string
    {
        return str_replace(' ', '', Carbon::now()->format('Y_m_d_H_i') . '_' . $originalName);
    }

    /**
     * @param Model $model
     * @return string
     */
    private function getFileStorePath(Model $model): string
    {
        return 'attachments/' . $model->getTable() . '/' . $model->id;
    }

    /**
     * @param string $fileName
     * @param string $filePath
     */
    private function revertFileStoreAction(string $fileName, string $filePath)
    {
        if (Storage::exists($filePath . '/' . $fileName)) {
            Storage::delete($filePath . '/' . $fileName);
        }
    }

    /**
     * @param File $file
     * @return bool
     */
    public function delete(File $file): bool
    {
        $this->revertFileStoreAction($file->name, $file->path);
        return $file->delete();
    }
}
