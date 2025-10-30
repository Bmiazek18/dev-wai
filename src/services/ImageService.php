<?php
namespace App\Services;
use MongoDB\Client;
use App\Models\Image;
class ImageService
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
    public function getAll(int $skip = 0, int $limit = 10): array
    {
        $cursor = $this->collection->find([], ['skip' => $skip, 'limit' => $limit]);
        return iterator_to_array($cursor);
    }
    public function getByIds(array $ids): array
    {
        $objectIds = array_map(fn($id) => new \MongoDB\BSON\ObjectId($id), $ids);
        $cursor = $this->collection->find(['_id' => ['$in' => $objectIds]]);
        return iterator_to_array($cursor);
    }

    public function count(): int
    {
        return $this->collection->countDocuments();
    }
}
