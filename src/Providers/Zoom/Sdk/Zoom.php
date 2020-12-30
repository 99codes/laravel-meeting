<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk;

use Closure;

class Zoom
{
    use Support\MakesHttpRequests;
    use Actions\ManagesRoles;
    use Actions\ManagesUsers;
    use Actions\ManagesMeetings;
    use Actions\ManagesPastMeetings;
    use Actions\ManagesRecordingFiles;
    use Actions\ManagesAccounts;
    use Actions\ManagesGroups;

    /**
     * The Guzzle HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    public $guzzle;

    /**
     * Create a new Zoom instance.
     *
     * @param string $apiKey
     * @return void
     */
    public function __construct(string $apiKey)
    {
        $this->guzzle = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.zoom.us/v2/',
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer '.$apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param array $collection
     * @param array $class
     * @param \Closure|null $paginator
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    protected function transformCollection(array $collection, array $class, ?Closure $paginator = null): Support\Repository
    {
        $collectionData = $collection;
        $attributes = [];

        [$class, $key] = $class;

        if ($key && isset($collection[$key])) {
            $collectionData = $collection[$key];
            unset($collection[$key]);
            $attributes = $collection;
        }

        $resources = array_map(
            fn ($data) => new $class($data, $this),
            $collectionData
        );

        $repository = new Support\Repository($resources, $attributes, $key);

        if ($paginator && is_callable($paginator)) {
            $repository->paginator($paginator);
        }
        
        return $repository;
    }
}
