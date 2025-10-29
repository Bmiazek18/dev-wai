<?php
namespace App\Models;
use MongoDB\BSON\UTCDateTime;
class User
{
    public string $username;
    public string $email;
    public string $passwordHash;
    public string $avatarFilename;
    public \DateTime $createdAt;

    public function __construct(
        string $username,
        string $email,
        string $password,
        string $avatarFilename,
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $this->avatarFilename = $avatarFilename;
        $this->createdAt = new \DateTime();
    }

    public function toDocument(): array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'passwordHash' => $this->passwordHash,
            'avatarFilename' => $this->avatarFilename,
            'created_at' => new UTCDateTime($this->createdAt->getTimestamp() * 1000),
        ];
    }
}
