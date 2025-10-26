<?php
require_once '../services/FileUploader.php';
require_once '../services/ImageRepository.php';
require_once '../models/Image.php';

class ImageController
{
    private FileUploader $uploader;
    private ImageRepository $repository;

    public function __construct()
    {
        $this->uploader = new FileUploader();
        $this->repository = new ImageRepository();
    }

    public function index(&$model)
    {
        return 'image_add_view';
    }
    public function store(array &$model)
    {
        $author = $_POST['author'] ?? '';
        $title = $_POST['title'] ?? '';
        $file = $_FILES['file'] ?? null;

        // 1️⃣ Upload pliku
        $uploadResult = $this->uploader->upload($file);
        if (!$uploadResult['success']) {
            $model['error'] = $uploadResult['error'];
            return 'upload_form';
        }

        $filename = $uploadResult['filename'];

        // 2️⃣ Utwórz model Image
        $image = new Image($author, $title, $filename);

        // 3️⃣ Zapis w MongoDB
        $saveSuccess = $this->repository->save($image);

        if ($saveSuccess) {
            $model['message'] = 'Plik został zapisany i dodany do bazy.';
            $model['filename'] = $filename;
            return 'upload_success';
        } else {
            unlink('uploads/' . $filename); // usuń plik jeśli zapis się nie udał
            $model['error'] = 'Nie udało się zapisać danych w bazie.';
            return 'upload_form';
        }
    }
}
