<?php
require_once '../Dispatcher.php';
require_once '../routing.php';
require_once '../controllers/ImageUploadController.php';

$action = $_GET['action'] ?? 'form';
$dispatcher = new Dispatcher($routing);
$dispatcher->dispatch($action);
