<?php

namespace App\Services;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ImageProcessingService
{
    private const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    /**
     * Validate, strip metadata, resize, recompress and store an uploaded image
     * under a randomly generated filename. Returns the stored path.
     */
    public function process(UploadedFile $file, string $directory, int $maxDimension, string $disk = 'public'): string
    {
        $info = @getimagesize($file->getRealPath());

        if ($info === false || ! in_array($info['mime'], self::ALLOWED_MIME_TYPES, true)) {
            throw ValidationException::withMessages([
                'image' => 'File yang diunggah bukan gambar yang didukung (jpeg, png, webp).',
            ]);
        }

        $mime = $info['mime'];
        $source = $this->readSource($file->getRealPath(), $mime);

        $width = imagesx($source);
        $height = imagesy($source);
        $scale = min(1, $maxDimension / max($width, $height));
        $targetWidth = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));

        $resized = imagecreatetruecolor($targetWidth, $targetHeight);
        $isPng = $mime === 'image/png';

        if ($isPng) {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefilledrectangle($resized, 0, 0, $targetWidth, $targetHeight, $transparent);
        }

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        imagedestroy($source);

        ob_start();
        if ($isPng) {
            imagepng($resized, null, 6);
            $extension = 'png';
        } else {
            imagejpeg($resized, null, 82);
            $extension = 'jpg';
        }
        $contents = ob_get_clean();
        imagedestroy($resized);

        $path = trim($directory, '/').'/'.Str::uuid()->toString().'.'.$extension;

        Storage::disk($disk)->put($path, $contents);

        return $path;
    }

    private function readSource(string $path, string $mime): GdImage
    {
        $source = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($path),
            'image/png' => imagecreatefrompng($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($path) : false,
            default => false,
        };

        if (! $source instanceof GdImage) {
            throw ValidationException::withMessages([
                'image' => 'Gagal memproses gambar yang diunggah.',
            ]);
        }

        return $source;
    }
}
