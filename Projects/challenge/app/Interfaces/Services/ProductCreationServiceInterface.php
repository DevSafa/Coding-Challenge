<?php

namespace App\Interfaces\Services;

use App\Models\Product;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

interface ProductCreationServiceInterface
{
    public function storeProduct(array $values): Product;
    public function validateData(array $values, bool $cli): bool;
    public function getFile(string $url): File;
    public function getUploadFile(File $file, string $name): UploadedFile;
}
