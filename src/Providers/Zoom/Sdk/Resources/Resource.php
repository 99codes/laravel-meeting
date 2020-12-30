<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;
use Nncodes\Meeting\Providers\Zoom\Sdk\Zoom;
use ReflectionProperty;

class Resource
{
    /**
     * The json file containing the zoom template
     *
     * @var string
     */
    protected string $template;

    /**
     * The resource attributes.
     *
     * @var array
     */
    protected array $attributes;

    /**
     * The Zoom SDK instance.
     *
     * @var \Nncodes\Meeting\Providers\Zoom\Sdk\Zoom|null
     */
    protected Zoom $zoom;

    /**
     * @var array
     */
    protected array $casts = [];

    /**
     * Create a new resource instance.
     *
     * @param array $attributes
     * @param  \Nncodes\Meeting\Providers\Zoom\Sdk\Zoom  $zoom
     * @return void
     */
    public function __construct(array $attributes, Zoom $zoom)
    {
        $this->attributes = $attributes;
        $this->zoom = $zoom;
        
        $this->fill();
    }

    /**
     * Fill the resource with the array of attributes.
     *
     * @return void
     */
    public function fill(): void
    {
        foreach ($this->attributes as $key => $value) {
            $camelKey = \Illuminate\Support\Str::camel($key);
           
            if (is_array($value) && property_exists($this, $camelKey)) {
                $property = new ReflectionProperty($this, $camelKey);

                if (optional($property->getType())->getName() === Repository::class) {
                    if ($castingKey = $this->casts[$key] ?? false) {
                        $this->{$camelKey} = $this->transformCollection($value, $castingKey);

                        continue;
                    }
                }
            }

            $this->{$camelKey} = $value;
        }
    }
  
    /**
     * Transform the items of the collection to the given class.
     *
     * @param array $collection
     * @param string $class
     * @param array $extraData
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    protected function transformCollection(array $collection, string $class, array $extraData = []): Repository
    {
        $resources = array_map(function ($data) use ($class) {
            return new $class($data, $this->zoom);
        }, $collection);

        return new Repository($resources, $extraData);
    }
}
