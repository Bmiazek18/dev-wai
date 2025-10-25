<?php
require_once 'business.php';
require_once 'controller_utils.php';

function products(&$model)
{
    $products = get_products();
    $model['products'] = $products;

    return 'products_view';
}

function product(&$model)
{
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        if ($product = get_product($id)) {
            $model['product'] = $product;
            return 'product_view';
        }
    }

    http_response_code(404);
    exit();
}

function edit(&$model)
{
    $product = [
        'name' => null,
        'price' => null,
        'description' => null,
        '_id' => null,
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['name']) && !empty($_POST['price']) /* && ...*/) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $product = [
                'name' => $_POST['name'],
                'price' => (int) $_POST['price'],
                'description' => $_POST['description'],
            ];

            if (save_product($id, $product)) {
                return 'redirect:products';
            }
        }
    } elseif (!empty($_GET['id'])) {
        $product = get_product($_GET['id']);
    }

    $model['product'] = $product;

    return 'edit_view';
}

function delete(&$model)
{
    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            delete_product($id);
            return 'redirect:products';
        } else {
            if ($product = get_product($id)) {
                $model['product'] = $product;
                return 'delete_view';
            }
        }
    }

    http_response_code(404);
    exit();
}

function cart(&$model)
{
    $model['cart'] = get_cart();
    return 'partial/cart_view';
}

function add_image()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir);
        }

        $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST['submit'])) {
            $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
            if ($check !== false) {
                echo 'File is an image - ' . $check['mime'] . '.';
                $uploadOk = 1;
            } else {
                echo 'File is not an image.';
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo 'Sorry, file already exists.';
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES['fileToUpload']['size'] > 5000000) {
            echo 'Sorry, your file is too large.';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != 'jpg' &&
            $imageFileType != 'png' &&
            $imageFileType != 'jpeg' &&
            $imageFileType != 'gif'
        ) {
            echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo 'Sorry, your file was not uploaded.';
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
                echo 'The file ' .
                    htmlspecialchars(basename($_FILES['fileToUpload']['name'])) .
                    ' has been uploaded.';
            } else {
                echo 'Sorry, there was an error uploading your file.';
            }
        }
    }

    return 'redirect:' . $_SERVER['HTTP_REFERER'];
}

function clear_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['cart'] = [];
        return 'redirect:' . $_SERVER['HTTP_REFERER'];
    }
}
