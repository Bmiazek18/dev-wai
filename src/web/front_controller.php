<?php
require_once '../../vendor/autoload.php';

require_once '../Dispatcher.php';
require_once '../routing.php';
require_once '../controllers/ImageController.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/GalleryController.php';

session_start();

$action = $_GET['action'] ?? 'form';
$dispatcher = new Dispatcher($routing);
$dispatcher->dispatch($action);
