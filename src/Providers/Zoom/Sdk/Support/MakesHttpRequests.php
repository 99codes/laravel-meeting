<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Support;

use Exception;
use Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\ConflictException;
use Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\FailedActionException;
use Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\NotFoundException;
use Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\TooManyRequestsException;
use Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\UnauthorizedException;
use Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

trait MakesHttpRequests
{
    /**
     * Serialize the http query parameters and include in the given URI
     *
     * @param  string  $uri
     * @param  array  $query
     * @return string
     */
    public function serializeUri(string $uri, array $query = [])
    {
        return $query ? $uri . "?". http_build_query($query) : $uri;
    }

    /**
     * Make a GET request to Zoom and return the response.
     *
     * @param  string  $uri
     * @param  array  $query
     * @return mixed
     */
    public function get($uri, array $query = [])
    {
        return $this->request('GET', $this->serializeUri($uri, $query));
    }

    /**
     * Make a POST request to Zoom and return the response.
     *
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    public function post($uri, array $payload = [])
    {
        return $this->request('POST', $uri, $payload);
    }

    /**
     * Make a PUT request to Zoom and return the response.
     *
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    public function put($uri, array $payload = [])
    {
        return $this->request('PUT', $uri, $payload);
    }

    /**
     * Make a PATCH request to Zoom and return the response.
     *
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    public function patch($uri, array $payload = [])
    {
        return $this->request('PATCH', $uri, $payload);
    }

    /**
     * Make a DELETE request to Zoom and return the response.
     *
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    public function delete($uri, array $payload = [])
    {
        return $this->request('DELETE', $uri, $payload);
    }

    /**
     * Make request to Zoom and return the response.
     *
     * @param  string  $verb
     * @param  string  $uri
     * @param  array  $payload
     * @return mixed
     */
    protected function request($verb, $uri, array $payload = [])
    {
        $response = $this->guzzle->request(
            $verb,
            $uri,
            empty($payload) ? [] : ['body' => json_encode($payload)]
        );

        if ($response->getStatusCode() >= 300) {
            throw $this->handleRequestError($response);
        }

        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    /**
     * Handle the request error.
     *
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @return void
     *
     * @throws \Exception
     * @throws \Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\ConflictException
     * @throws \Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\FailedActionException
     * @throws \Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\NotFoundException
     * @throws \Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\TooManyRequestsException
     * @throws \Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\UnauthorizedException
     * @throws \Nncodes\Meeting\Providers\Zoom\Sdk\Exceptions\ValidationException
     * @return Throwable
     */
    protected function handleRequestError(ResponseInterface $response): Throwable
    {
        $body = json_decode((string) $response->getBody());
        $statusCode = $response->getStatusCode();

        $exceptionsHandler = [
            400 => $body->code == 300 ? ValidationException::class: FailedActionException::class,
            401 => UnauthorizedException::class,
            404 => NotFoundException::class,
            409 => ConflictException::class,
            429 => TooManyRequestsException::class,
        ];

        if (array_key_exists($statusCode, $exceptionsHandler)) {
            return new $exceptionsHandler[$statusCode]($body, $statusCode);
        }
        
        return new Exception($body->message, $statusCode);
    }
}
