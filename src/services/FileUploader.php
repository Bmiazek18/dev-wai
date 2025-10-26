<?php
class FileUploader
{
    private $uploadDir = 'uploads/';
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    private $maxSize = 10 * 1024 * 1024; // 1 MB
    private int $thumbWidth = 200;
    private int $thumbHeight = 125;

    private function createThumbnail(string $filePath, string $thumbDir)
    {
        if (!file_exists($filePath)) {
            return false;
        }
        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0775, true);
        }

        $info = getimagesize($filePath);
        if ($info === false) {
            return false;
        }

        [$origW, $origH, $type] = $info;

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
                return false; // tylko JPG i PNG
        }

        $baseName = pathinfo($filePath, PATHINFO_FILENAME);
        $thumbPath = rtrim($thumbDir, '/') . '/' . $baseName . '.' . $ext;

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
            imagejpeg($thumbImg, $thumbPath, 90);
        } elseif ($ext === 'png') {
            imagepng($thumbImg, $thumbPath, 6);
        }

        imagedestroy($srcImg);
        imagedestroy($thumbImg);

        return $thumbPath;
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
            $this->createThumbnail($target, $this->uploadDir . 'thumbs/');
            return ['success' => true, 'filename' => $filename];
        }

        return ['success' => false, 'error' => 'Nie udało się zapisać pliku.'];
    }
}
