<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Actions;

use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\CloudRecording;
use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Meeting;
use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\User;
use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

trait ManagesUsers
{
    /**
     * Verify if a user’s email is registered with Zoom.
     *
     * @param array $query
     * @return array
     */
    public function checkUserEmail(array $query = []): array
    {
        return $this->get("users/email?".http_build_query($query));
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\User
     */
    public function createUser(array $data): User
    {
        return new User($this->post("users", $data), $this);
    }

    /**
     * Create a new meeting for the user
     *
     * @param string $userId
     * @param array $data
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Meeting
     */
    public function createUserMeeting(string $userId, array $data): Meeting
    {
        return new Meeting($this->post("users/{$userId}/meetings", $data), $this);
    }

    /**
     * Delete a user
     *
     * @param string $userId
     * @param array $query
     * @return void
     */
    public function deleteUser(string $userId, array $query = []): void
    {
        $this->delete("users/{$userId}?".http_build_query($query));
    }

    /**
     * Update a user
     *
     * @param string $userId
     * @param array $data
     * @param array $query
     * @return void
     */
    public function updateUser(string $userId, array $data, array $query = []): void
    {
        $this->patch("users/{$userId}?".http_build_query($query), $data);
    }

    /**
     * Update the user's email.
     *
     * @param string $userId
     * @param array $data
     * @return void
     */
    public function updateUserEmail(string $userId, array $data): void
    {
        $this->put("users/{$userId}/email", $data);
    }

    /**
     * Update the user's password.
     *
     * @param string $userId
     * @param array $data
     * @return void
     */
    public function updateUserPassword(string $userId, array $data): void
    {
        $this->put("users/{$userId}/password", $data);
    }

    /**
     * Update the user's status.
     *
     * @param string $userId
     * @param array $data
     * @return void
     */
    public function updateUserStatus(string $userId, array $data): void
    {
        $this->put("users/{$userId}/status", $data);
    }

    /**
     * Get a instance of user
     *
     * @param string $userId
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\User
     */
    public function user(string $userId, array $query = []): User
    {
        return new User($this->get("users/{$userId}?".http_build_query($query)), $this);
    }

    /**
     * Get the collection of user's meetings
     *
     * @param array $query
     * @param string $userId User Id.
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function userMeetings(string $userId, array $query = []): Repository
    {
        $request = fn ($query, $paginator) => $this->transformCollection(
            $this->get("users/{$userId}/meetings?".http_build_query($query)),
            [Meeting::class, 'meetings'],
            $paginator
        );

        return $request($query, $request);
    }

    /**
     * Get the list of permissions for the user
     *
     * @param string $userId The user ID
     * @return array
     */
    public function userPermissions(string $userId): array
    {
        return $this->get("users/{$userId}/permissions");
    }

    /**
     * Get the collection of recordings of a user
     *
     * @param string $userId
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function userRecordings(string $userId, array $query = []): Repository
    {
        $request = fn ($query, $paginator) => $this->transformCollection(
            $this->get("users/{$userId}/recordings?".http_build_query($query)),
            [CloudRecording::class, 'meetings'],
            $paginator
        );

        return $request($query, $request);
    }

    /**
     * Get the collection of users.
     *
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function users(array $query = []): Repository
    {
        $request = fn ($query, $paginator) => $this->transformCollection(
            $this->get("users?".http_build_query($query)),
            [User::class, 'users'],
            $paginator
        );

        return $request($query, $request);
    }
}
