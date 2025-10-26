<?php

use MongoDB\BSON\UTCDateTime;

class Image
{
    public string $author;
    public string $title;
    public string $filename;
    public \DateTime $createdAt;

    public function __construct(string $author, string $title, string $filename)
    {
        $this->author = $author;
        $this->title = $title;
        $this->filename = $filename;
        $this->createdAt = new \DateTime();
    }

    // Zamienia model na dokument do MongoDB
    public function toDocument(): array
    {
        return [
            'author' => $this->author,
            'title' => $this->title,
            'filename' => $this->filename,
            'created_at' => new UTCDateTime($this->createdAt->getTimestamp() * 1000),
        ];
    }
}
