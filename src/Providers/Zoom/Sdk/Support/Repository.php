<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Support;

use Exception;
use Illuminate\Support\Collection;
use ReflectionClass;

class Repository
{

     /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $collection;

    /**
     * @var \ReflectionClass
     */
    protected ReflectionClass $reflection;

    /**
     * @var string
     */
    protected string $key;

    /**
     * The number of pages returned for the request made.
     * @var int
     */
    public int $pageCount;

    /**
     * The page number of the current results.
     * @var int
     */
    public int $pageNumber;

    /**
     * The number of records returned with a single API call.
     * @var int
     */
    public int $pageSize;

    /**
     * The total number of all the records available across pages.
     * @var int
     */
    public int $totalRecords;

    /**
     * The next page token is used to paginate through large result sets. A next page token will be returned whenever the set of available results exceeds the current page size. The expiration period for this token is 15 minutes.
     * @var string
     */
    public string $nextPageToken;

    /**
     *
     * @var mixed
     */
    protected $paginator;

    /**
     * Undocumented function
     *
     * @param array $items
     * @param array $attributes
     * @param string|null $key
     */
    public function __construct(array $items, array $attributes = [], ?string $key)
    {
        $this->reflection = new ReflectionClass(Collection::class);
        $this->build($items, $attributes, $key);
    }

    /**
     * Undocumented function
     *
     * @param array $items
     * @param array $attributes
     * @param string|null $key
     * @return void
     */
    protected function build(array $items, array $attributes = [], ?string $key): void
    {
        $this->key = $key ? $key : 'collection';
        
        $this->createCollection($items);

        foreach ($attributes as $key => $value) {
            $key = \Illuminate\Support\Str::camel($key);
            $this->{$key} = $value;
        }
    }
    
    /**
     * Undocumented function
     *
     * @param array $items
     * @return self
     */
    protected function createCollection(array $items): self
    {
        $this->{$this->key} = new Collection($items);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Support\Collection|null
     */
    protected function collection(): ?Collection
    {
        return $this->{$this->key};
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function forgetCollection(): void
    {
        unset($this->{$this->key});
        $this->reflection = null;
    }

    /**
     * Undocumented function
     *
     * @param mixed $paginator
     * @return void
     */
    public function paginator($paginator): void
    {
        $this->paginator = $paginator;
        $this->pageNumber = 1;
    }

    /**
     * Undocumented function
     *
     * @return self
     */
    public function nextPage(): self
    {
        if (empty($this->nextPageToken) || ! $paginator = $this->paginator) {
            return $this;
            //@todo Exception
        }

        $query = [
            'next_page_token' => $this->nextPageToken,
            'page_size' => $this->pageSize,
        ];
        
        $repository = $paginator($query, $this->paginator);

        $this->pageNumber++;
        
        $this->build($repository->collection()->all(), [
            'next_page_token' => $repository->nextPageToken,
        ], $this->key);
        
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if ($this->reflection->hasMethod($name) === false) {
            throw new Exception(sprintf("Call undefined function '%s' in '%s'", $name, $this->reflection->getName()));
        }
              
        return $arguments ? call_user_func_array([$this->{$this->key}, $name], $arguments) : $this->{$this->key}->$name();
    }
}
