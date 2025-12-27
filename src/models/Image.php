<?php
namespace App\Models;
use MongoDB\BSON\UTCDateTime;

class Image
{
    public string $author;
    public string $title;
    public string $filename;
    public \DateTime $createdAt;
    public bool $isPrivate; // New property
    public ?string $userId; // New property, nullable

    public function __construct(string $author, string $title, string $filename, bool $isPrivate = false, ?string $userId = null)
    {
        $this->author = $author;
        $this->title = $title;
        $this->filename = $filename;
        $this->createdAt = new \DateTime();
        $this->isPrivate = $isPrivate; // Initialize new property
        $this->userId = $userId; // Initialize new property
    }

    public function toDocument(): array
    {
        return [
            'author' => $this->author,
            'title' => $this->title,
            'filename' => $this->filename,
            'created_at' => new UTCDateTime($this->createdAt->getTimestamp() * 1000),
            'is_private' => $this->isPrivate, // Add to document
            'user_id' => $this->userId, // Add to document
        ];
    }
}
