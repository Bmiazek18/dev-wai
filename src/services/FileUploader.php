<?php
namespace App\Services;
class FileUploader
{
    private string $uploadDir;
    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    private int $maxSize = 10 * 1024 * 1024; // 10 MB
    private int $thumbWidth = 200;
    private int $thumbHeight = 125;

    public function __construct(string $uploadDir = 'uploads/')
    {
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0775, true);
        }
    }

    public function createThumbnail(
        string $filePath,
        bool $useThumbDir = false,
        bool $uniqueName = false,
    ): array {
        if (!file_exists($filePath)) {
            return ['success' => false, 'error' => 'Plik źródłowy nie istnieje.'];
        }

        $info = getimagesize($filePath);
        if ($info === false) {
            return ['success' => false, 'error' => 'Nieprawidłowy format obrazu.'];
        }

        [$origW, $origH, $type] = $info;

        // Wczytaj źródło
        switch ($type) {
            case IMAGETYPE_JPEG:
                $srcImg = imagecreatefromjpeg($filePath);
                $ext = 'jpg';
                break;
            case IMAGETYPE_PNG:
                $srcImg = imagecreatefrompng($filePath);
                $ext = 'png';
                break;
            default:
                return ['success' => false, 'error' => 'Obsługiwane tylko JPG i PNG.'];
        }

        // Nazwa miniatury jest zawsze unikalna
        $filename = $uniqueName ? uniqid('thumb_', true) . '.' . $ext : basename($filePath);
        $thumbDir = $useThumbDir ? $this->uploadDir . 'thumbs/' : $this->uploadDir;

        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0775, true);
        }

        $thumbPath = $thumbDir . $filename;

        // Miniatura dokładnie w zadanym rozmiarze (rozciągnięcie)
        $thumbImg = imagecreatetruecolor($this->thumbWidth, $this->thumbHeight);
        $white = imagecolorallocate($thumbImg, 255, 255, 255);
        imagefilledrectangle($thumbImg, 0, 0, $this->thumbWidth, $this->thumbHeight, $white);

        imagecopyresampled(
            $thumbImg,
            $srcImg,
            0,
            0,
            0,
            0,
            $this->thumbWidth,
            $this->thumbHeight,
            $origW,
            $origH,
        );

        if ($ext === 'jpg') {
            $success = imagejpeg($thumbImg, $thumbPath, 90);
        } elseif ($ext === 'png') {
            $success = imagepng($thumbImg, $thumbPath, 6);
        } else {
            $success = false;
        }

        imagedestroy($srcImg);
        imagedestroy($thumbImg);

        return [
            'success' => $success,
            'filename' => $success ? basename($thumbPath) : null,
            'path' => $success ? $thumbPath : null,
        ];
    }

    public function upload($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Błąd podczas przesyłania pliku.'];
        }

        if (!in_array($file['type'], $this->allowedTypes)) {
            return ['success' => false, 'error' => 'Dozwolone tylko pliki JPG i PNG.'];
        }

        if ($file['size'] > $this->maxSize) {
            return ['success' => false, 'error' => 'Plik za duży (max 1MB).'];
        }

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }

        $filename = basename($file['name']);
        $target = $this->uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            $this->createThumbnail($target, true, false);
            return ['success' => true, 'filename' => $filename];
        }

        return ['success' => false, 'error' => 'Nie udało się zapisać pliku.'];
    }
}
