<?php

namespace App\Services;

use App\Models\File;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductService
{
    /**
     * @param User|Authenticatable $user
     * @param array $data
     * @param UploadedFile|null $file
     * @return Product
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(User|Authenticatable $user, array $data, UploadedFile $file = null): Product
    {
        $product = new Product($data);
        $product->user()->associate($user);
        $product->save();

        if ($file) {
            /** @var FileService $fileService */
            $fileService = app()->make(FileService::class);
            $fileService->store($file, $product);
        }
        return $product;
    }

    /**
     * @param Product $product
     * @param array $data
     * @param UploadedFile|null $file
     * @return Product
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update(Product $product, array $data, UploadedFile $file = null): Product
    {
        $product->fill($data);
        $product->save();

        if ($file) {
            /** @var FileService $fileService */
            $fileService = app()->make(FileService::class);
            /** @var File $productFile */
            $productFile = $product->files()->first();
            $fileService->delete($productFile);
            $fileService->store($file, $product);
        }
        return $product;
    }
}
