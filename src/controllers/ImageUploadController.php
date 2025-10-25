<?php
require_once '../service/ImageUploadService.php';

class ImageUploadController
{
    private $service;

    public function __construct()
    {
        $this->service = new ImageUploadService();
    }
    public function index(&$model)
    {
        return 'image_add_view';
    }

    public function store(&$model)
    {
        if (!isset($_FILES['file'])) {
            $model['error'] = 'Nie przesłano pliku.';
            return 'image_add_view';
        }
        $result = $this->service->upload($_FILES['file']);
        if ($result['success']) {
            $model['filename'] = $result['filename'];
            return 'upload_success';
        } else {
            $model['error'] = $result['error'];
            return 'image_add_view';
        }
    }
}
