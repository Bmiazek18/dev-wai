<?php

use MongoDB\BSON\ObjectID;

class ImageRepository
{
    private $collection;

    public function __construct()
    {
        $client = new MongoDB\Client('mongodb://localhost:27017/wai', [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);
        $this->collection = $client->wai->images;
    }

    public function save(Image $image): bool
    {
        $result = $this->collection->insertOne($image->toDocument());
        return $result->getInsertedCount() === 1;
    }
}
