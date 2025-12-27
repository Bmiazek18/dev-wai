<?php
namespace App\Controllers;

use App\Services\FileUploader;
use App\Services\ImageService;
use App\Models\Image;

class ImageController
{
    private FileUploader $uploader;
    private ImageService $service;

    public function __construct()
    {
        $this->uploader = new FileUploader();
        $this->service = new ImageService();
    }

    public function index(&$model)
    {
        return 'upload_form_view';
    }
    public function search_index(&$model)
    {
        return 'search_view';
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

        // Retrieve visibility status
        $visibility = $_POST['visibility'] ?? 'public'; // Default to public
        $isPrivate = ($visibility === 'private');

        // Retrieve logged-in user's ID
        $userId = $_SESSION['user']['id'] ?? null;

        // 2️⃣ Utwórz model Image
        $image = new Image($author, $title, $filename, $isPrivate, $userId);

        // 3️⃣ Zapis w MongoDB
        $saveSuccess = $this->service->save($image);

        if ($saveSuccess) {
            $model['message'] = 'Plik został zapisany i dodany do bazy.';
            return 'gallery_view';
        } else {
            unlink('uploads/' . $filename); // usuń plik jeśli zapis się nie udał
            $model['error'] = 'Nie udało się zapisać danych w bazie.';
            return 'upload_form_view';
        }
    }
    public function remember(array &$model)
    {
        $selected = $_POST['selected'] ?? [];

        // Jeśli nic nie zaznaczono — wyczyść sesję
        if (empty($selected)) {
            $_SESSION['favorites'] = [];
        } else {
            foreach ($selected as $id) {
                if (!isset($_SESSION['favorites'][$id])) {
                    $_SESSION['favorites'][$id] = ['quantity' => 1];
                }
            }
        }

        // Odswież licznik
        $model['cartCount'] = $this->getTotalFavoriteCount();

        return 'redirect:/';
    }

    // 📄 Podstrona z zapamiętanymi zdjęciami
    public function remembered(array &$model)
    {
        $favorites = $_SESSION['favorites'] ?? [];

        $ids = array_keys($favorites);
        $images = $this->service->getByIds($ids);

        $model['images'] = $images;
        $model['favorites'] = $favorites;
        $model['cartCount'] = $this->getTotalFavoriteCount();

        return 'favorites_view';
    }

    // ❌ Usuwanie zaznaczonych zdjęć z zapamiętanych
    public function removeRemembered(array &$model)
    {
        $remove = $_POST['remove'] ?? [];

        foreach ($remove as $id) {
            unset($_SESSION['favorites'][$id]);
        }

        return 'redirect:/zapamietane';
    }

    // 🔢 Zmiana ilości (np. 2 odbitki)
    public function updateQuantity(array &$model)
    {
        foreach ($_POST['quantity'] ?? [] as $id => $qty) {
            if (isset($_SESSION['favorites'][$id])) {
                $_SESSION['favorites'][$id]['quantity'] = max(1, (int) $qty);
            }
        }

        return 'redirect:/zapamietane';
    }

    private function getTotalFavoriteCount(): int
    {
        $total = 0;
        foreach ($_SESSION['favorites'] ?? [] as $fav) {
            $total += $fav['quantity'];
        }
        return $total;
    }
    public function ajaxSearch()
    {
        $query = $_GET['q'] ?? '';
        $currentUserId = $_SESSION['user']['id'] ?? null; // Get current user ID

        $photos = $this->service->searchByTitle($query, $currentUserId); // Pass current user ID

        $html = '';
        foreach ($photos as $img) {
            $filename = htmlspecialchars($img['filename']);
            $title = htmlspecialchars($img['title']);
            $author = htmlspecialchars($img['author']);
            $isPrivate = isset($img['is_private']) && $img['is_private']; // Check if private

            $html .= "
                <div class='image-item'>
                    <img src='uploads/thumbs/{$filename}' alt='{$title}'>
                    <p><strong>{$title}</strong><br>{$author}";
            if ($isPrivate) {
                $html .= " <span style='color: red; font-weight: bold;'>(Prywatne)</span>";
            }
            $html .= "</p>
                </div>
            ";
        }

        return ['raw' => $html]; // Return as raw HTML
    }
}
