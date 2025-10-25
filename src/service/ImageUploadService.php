<?php
class ImageUploadService
{
    private $uploadDir = 'uploads/';
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    private $maxSize = 10 * 1024 * 1024; // 1 MB

    private function createThumbnailFromServerFile(
        string $filePath,
        string $thumbDir = __DIR__ . '/thumbs',
        int $thumbWidth = 200,
        int $thumbHeight = 125,
    ) {
        if (!file_exists($filePath)) {
            return false;
        }

        // Utwórz folder miniatur, jeśli nie istnieje
        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0775, true);
        }

        // Pobierz informacje o pliku
        $info = getimagesize($filePath);
        if ($info === false) {
            return false;
        }

        [$origW, $origH, $type] = $info;

        // Ustal format docelowy i rozszerzenie
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

        // Zbuduj ścieżkę docelową miniatury (z oryginalnym rozszerzeniem)
        $baseName = pathinfo($filePath, PATHINFO_FILENAME);
        $thumbPath = rtrim($thumbDir, '/') . '/' . $baseName . '.' . $ext;

        // Utwórz docelowy obraz o stałym rozmiarze 200x125
        $thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);

        // Ustaw tło na białe
        $white = imagecolorallocate($thumbImg, 255, 255, 255);
        imagefilledrectangle($thumbImg, 0, 0, $thumbWidth, $thumbHeight, $white);

        // Przeskaluj i wklej obraz źródłowy (bez zachowania proporcji)
        imagecopyresampled(
            $thumbImg,
            $srcImg,
            0,
            0,
            0,
            0,
            $thumbWidth,
            $thumbHeight,
            $origW,
            $origH,
        );

        // Zapisz miniaturę w odpowiednim formacie
        if ($ext === 'jpg') {
            imagejpeg($thumbImg, $thumbPath, 90);
        } elseif ($ext === 'png') {
            // PNG – kompresja od 0 (najlepsza jakość) do 9 (najmniejszy rozmiar)
            imagepng($thumbImg, $thumbPath, 6);
        }

        // Zwolnij pamięć
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
            $this->createThumbnailFromServerFile($target, $this->uploadDir . 'thumbs/');
            return ['success' => true, 'filename' => $filename];
        }

        return ['success' => false, 'error' => 'Nie udało się zapisać pliku.'];
    }
}
