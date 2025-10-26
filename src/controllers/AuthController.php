<?php
use App\services\FileUploader;
use App\Services\UserService;
use App\Models\User;

class AuthController
{
    private UserService $userService;
    private FileUploader $avatarUploader;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->avatarUploader = new FileUploader('uploads/ProfilesFoto');
    }

    public function register_index(&$model)
    {
        return 'register_form_view';
    }
    public function login_index(&$model)
    {
        return 'login_form_view';
    }

    public function register(array &$model)
    {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $file = $_FILES['file'] ?? null;

        if (empty($username) || empty($email) || empty($password) || $file === null) {
            $model['error'] = 'Wszystkie pola są wymagane';
            return 'register_form_view';
        }
        $avatarFilename = null;
        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            $result = $this->avatarUploader->upload($file);
            if (!$result['success']) {
                $model['error'] = $result['error'];
                return 'register_form';
            }
            $avatarFilename = $result['filename'];
        }

        $user = new User($username, $email, $password, $avatarFilename);

        $result = $this->userService->register($user);

        if ($result['success']) {
            $model['message'] = 'Rejestracja zakończona sukcesem';
            return 'login_form_view';
        } else {
            $model['error'] = $result['error'];
            return 'register_form_view';
        }
    }

    public function login(array &$model)
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $model['error'] = 'Email i hasło są wymagane';
            return 'login_form_view';
        }

        $result = $this->userService->login($email, $password);
        if ($result['success']) {
            $model['user'] = $result['user'];
            return 'gallery_view';
        } else {
            $model['error'] = $result['error'];
            return 'login_form_view';
        }
    }
}
