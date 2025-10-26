<?php
use App\Services\FileUploader;
use App\Services\ImageRepository;
use App\Models\Image;

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
        return 'upload_form_view';
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
            return 'upload_form_view';
        }

        $filename = $uploadResult['filename'];

        // 2️⃣ Utwórz model Image
        $image = new Image($author, $title, $filename);

        // 3️⃣ Zapis w MongoDB
        $saveSuccess = $this->repository->save($image);

        if ($saveSuccess) {
            $model['message'] = 'Plik został zapisany i dodany do bazy.';
            $model['filename'] = $filename;
            return 'gallery_view';
        } else {
            unlink('uploads/' . $filename); // usuń plik jeśli zapis się nie udał
            $model['error'] = 'Nie udało się zapisać danych w bazie.';
            return 'upload_form_view';
        }
    }
}
