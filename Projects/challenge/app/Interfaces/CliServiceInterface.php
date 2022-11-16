<?php
namespace App\Interfaces;

use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\ProductServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;

interface CliServiceInterface 
{
    public function getCategoryService(): CategoryServiceInterface;
    public function getProductService(): ProductServiceInterface;
    public function getUploadFile(File $file , string $name): UploadedFile;
    public function getFile(string $url): File;
}
