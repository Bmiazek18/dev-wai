<?php
use App\Services\ImageService;
class GalleryController
{
    private ImageService $service;

    public function __construct()
    {
        $this->service = new ImageService();
    }

    public function index(array &$model)
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = 6;
        $skip = ($page - 1) * $perPage;
        $images = $this->service->getAll($skip, $perPage);
        $total = $this->service->count();
        $totalPages = (int) ceil($total / $perPage);

        $model = [
            'images' => $images,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ];
        return 'gallery_view';
    }
}
