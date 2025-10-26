<?php
namespace App\Services;
use MongoDB\Client;
use App\Models\Image;
class ImageRepository
{
    private $collection;

    public function __construct()
    {
        $client = new Client('mongodb://localhost:27017/wai', [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);
        $this->collection = $client->wai->images;
    }

    public function save(Image $image)
    {
        $result = $this->collection->insertOne($image->toDocument());
        return $result->getInsertedCount() === 1;
    }
}
