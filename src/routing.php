<?php

$routing = [
    '/dodaj-zdjecie' => ['controller' => 'ImageController', 'action' => 'index'],
    '/upload' => ['controller' => 'ImageController', 'action' => 'store'],
    '/' => ['controller' => 'GalleryController', 'action' => 'index'],
];
