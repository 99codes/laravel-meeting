<?php

namespace Nncodes\Meeting\Providers\Zoom;

use Closure;
use Nncodes\Meeting\Providers\Zoom\Support\Repository;

class Zoom
{
    use Support\MakesHttpRequests,
        Actions\ManagesRoles,
        Actions\ManagesUsers,
        Actions\ManagesMeetings,
        Actions\ManagesPastMeetings,
        Actions\ManagesRecordingFiles,
        Actions\ManagesAccounts;

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
    * @return \Nncodes\Meeting\Providers\Zoom\Support\Repository
    */
    protected function transformCollection(array $collection, array $class, ?Closure $paginator): Repository
    {
        $collectionData = $collection;
        $attributes = [];

        [$class, $key] = $class;

        if( $key && isset($collection[$key])){
            $collectionData = $collection[$key];
            unset($collection[$key]);
            $attributes = $collection;
        }

        $resources = array_map(
            fn ($data) => new $class($data, $this), 
            $collectionData
        );

        $repository = new Support\Repository($resources, $attributes, $key);

        if( $paginator && is_callable($paginator)){
            $repository->paginator($paginator);
        }
        
        return $repository;
    }
}
