<?php
namespace App\Services;
use MongoDB\Client;
use App\Models\User;
class UserService
{
    private $collection;

    public function __construct()
    {
        $client = new Client('mongodb://localhost:27017/wai', [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);
        $this->collection = $client->wai->users;
    }

    public function register(User $user): array
    {
        // Sprawdź, czy email już istnieje
        $existing = $this->collection->findOne(['username' => $user->username]);
        if ($existing) {
            return ['success' => false, 'error' => 'Nazwa użytkownika jest już zajęta'];
        }

        $result = $this->collection->insertOne($user->toDocument());
        return $result->getInsertedCount() === 1
            ? ['success' => true]
            : ['success' => false, 'error' => 'Błąd zapisu do bazy'];
    }

    public function login(string $email, string $password): array
    {
        $user = $this->collection->findOne(['email' => $email]);
        if (!$user) {
            return ['success' => false, 'error' => 'Nieprawidłowy email lub hasło'];
        }

        if (!password_verify($password, $user['passwordHash'])) {
            return ['success' => false, 'error' => 'Nieprawidłowy email lub hasło'];
        }

        return ['success' => true, 'user' => $user];
    }
}
