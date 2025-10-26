<?php

class GalleryController
{
    private $service;

    public function index(&$model)
    {
        $thumbDir = '/var/www/dev/src/web' . '/uploads/thumbs';
        $thumbs = glob($thumbDir . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
        $model['thumbs'] = $thumbs;
        return 'gallery_view';
    }
}
