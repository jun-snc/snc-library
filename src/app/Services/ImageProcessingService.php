<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

class ImageProcessingService
{
    public function processAndStore(UploadedFile $file, string $libraryType): array
    {
        $uuid = (string) Str::uuid();
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');

        $originalDir = "uploads/{$libraryType}/original";
        $displayDir = "uploads/{$libraryType}/display";
        $thumbDir = "uploads/{$libraryType}/thumb";

        Storage::disk('public')->makeDirectory($originalDir);
        Storage::disk('public')->makeDirectory($displayDir);
        Storage::disk('public')->makeDirectory($thumbDir);

        $originalPath = $originalDir . '/' . $uuid . '.' . $extension;
        Storage::disk('public')->put($originalPath, file_get_contents($file->getRealPath()));

        $manager = $this->createImageManager();
        $baseImage = $manager->read($file->getPathname());

        $width = $baseImage->width();
        $height = $baseImage->height();

        $maxDisplay = (int) env('MAX_DISPLAY_WIDTH', 4096);
        $maxThumb = (int) env('THUMB_MAX_SIZE', 512);

        $displayImage = $manager->read($file->getPathname());
        $displayImage->scaleDown($maxDisplay, $maxDisplay);
        $displayEncoded = $displayImage->toJpeg(85);
        $displayPath = $displayDir . '/' . $uuid . '.jpg';
        Storage::disk('public')->put($displayPath, $displayEncoded->toString());

        $thumbImage = $manager->read($file->getPathname());
        $thumbImage->scaleDown($maxThumb, $maxThumb);
        $thumbEncoded = $thumbImage->toJpeg(85);
        $thumbPath = $thumbDir . '/' . $uuid . '.jpg';
        Storage::disk('public')->put($thumbPath, $thumbEncoded->toString());

        return [
            'original_path' => $originalPath,
            'display_path' => $displayPath,
            'thumb_path' => $thumbPath,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'width' => $width,
            'height' => $height,
        ];
    }

    private function createImageManager(): ImageManager
    {
        if (extension_loaded('imagick')) {
            return new ImageManager(new ImagickDriver());
        }

        return new ImageManager(new GdDriver());
    }
}
