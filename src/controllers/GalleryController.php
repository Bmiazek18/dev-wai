<?php

class GalleryController
{
    private $service;

    public function index(&$model)
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = 6;

        $model['thumbs'] = $this->model->getThumbs($page, $perPage);
        $model['currentPage'] = $page;
        $model['totalPages'] = $this->model->getTotalPages($perPage);
        return 'gallery_view';
    }
}
