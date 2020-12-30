<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Actions;

use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Group;
use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\User;
use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

trait ManagesGroups
{
    /**
     * Add members to a group.
     *
     * @param string $groupId
     * @param array $data
     * @return array
     */
    public function addMembers(string $groupId, array $data): array
    {
        return $this->post("groups/{$groupId}/members", $data);
    }

    /**
     * Create a new group
     *
     * @param array $data
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Group
     */
    public function createGroup(array $data): Group
    {
        return new Group($this->post("groups", $data), $this);
    }

    /**
     * Delete a group
     *
     * @param string $groupId Group Id.
     * @return void
     */
    public function deleteGroup(string $groupId): void
    {
        $this->delete("groups/{$groupId}");
    }

    /**
     * Delete a group member
     *
     * @param string $groupId Group Id.
     * @param string $memberId Member Id.
     * @return void
     */
    public function deleteMember(string $groupId, string $memberId): void
    {
        $this->delete("groups/{$groupId}/members/{$memberId}");
    }

    /**
     * Get a instance of group
     *
     * @param string $groupId
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Group
     */
    public function group(string $groupId): Group
    {
        return new Group($this->get("groups/{$groupId}"), $this);
    }

    /**
     * List the members of a group.
     *
     * @param string $groupId
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function groupMembers(string $groupId, array $query = []): Repository
    {
        $request = fn ($query, $paginator) => $this->transformCollection(
            $this->get("groups/{$groupId}/members?".http_build_query($query)),
            [User::class, 'members'],
            $paginator
        );

        return $request($query, $request);
    }

    /**
     * Get the collection of groups.
     *
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function groups(): Repository
    {
        return $this->transformCollection(
            $this->get("groups"),
            [Group::class, 'groups']
        );
    }

    /**
     * Update a group
     *
     * @param string $groupId
     * @param array $data
     * @return void
     */
    public function updateGroup(string $groupId, array $data): void
    {
        $this->patch("groups/{$groupId}", $data);
    }

    /**
     * Update a group member
     *
     * @param string $groupId
     * @param string $memberId
     * @param array $data
     * @return void
     */
    public function updateMember(string $groupId, string $memberId, array $data): void
    {
        $this->patch("groups/{$groupId}/members/{$memberId}", $data);
    }
}
