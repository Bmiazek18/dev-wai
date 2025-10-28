<?php

$routing = [
    '/dodaj-zdjecie' => ['controller' => 'ImageController', 'action' => 'index'],
    '/rejestracja' => ['controller' => 'AuthController', 'action' => 'register_index'],
    '/logowanie' => ['controller' => 'AuthController', 'action' => 'login_index'],
    '/auth/register' => ['controller' => 'AuthController', 'action' => 'register'],
    '/auth/login' => ['controller' => 'AuthController', 'action' => 'login'],
    '/auth/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
    '/upload' => ['controller' => 'ImageController', 'action' => 'store'],
    '/' => ['controller' => 'GalleryController', 'action' => 'index'],
];
