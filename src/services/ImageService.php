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
    public function getAll(int $skip = 0, int $limit = 10, ?string $currentUserId = null): array
    {
        $query = ['is_private' => false]; // Default: only public images

        if ($currentUserId !== null) {
            // If a user is logged in, show their private images as well
            $query = [
                '$or' => [
                    ['is_private' => false], // Public images
                    ['user_id' => $currentUserId] // Current user's private images
                ]
            ];
        }
        $cursor = $this->collection->find($query, ['skip' => $skip, 'limit' => $limit]);
        return iterator_to_array($cursor);
    }
    public function getByIds(array $ids): array
    {
        $objectIds = array_map(fn($id) => new \MongoDB\BSON\ObjectId($id), $ids);
        $cursor = $this->collection->find(['_id' => ['$in' => $objectIds]]);
        return iterator_to_array($cursor);
    }
    public function searchByTitle(string $query)
    {
        if ($query === '') {
            return [];
        }
        $cursor = $this->collection->find([
            'title' => ['$regex' => $query, '$options' => 'i'],
        ]);
        return iterator_to_array($cursor);
    }

    public function count(?string $currentUserId = null): int
    {
        $query = ['is_private' => false]; // Default: only public images

        if ($currentUserId !== null) {
            // If a user is logged in, count their private images as well
            $query = [
                '$or' => [
                    ['is_private' => false], // Public images
                    ['user_id' => $currentUserId] // Current user's private images
                ]
            ];
        }
        return $this->collection->countDocuments($query);
    }
}
