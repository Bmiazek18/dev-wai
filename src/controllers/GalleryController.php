<?php
namespace App\Controllers;

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

        $currentUserId = $_SESSION['user']['id'] ?? null;

        $images = $this->service->getAll($skip, $perPage, $currentUserId);
        $total = $this->service->count($currentUserId);
        $totalPages = (int) ceil($total / $perPage);

        $model = [
            'images' => $images,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ];
        return 'gallery_view';
    }
}
