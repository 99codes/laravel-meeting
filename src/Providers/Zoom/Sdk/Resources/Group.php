<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

/**
 * Group
 */
class Group extends Resource
{
    /**
     * Group Id.
     * @var string
     */
    public string $id;

    /**
     * Name of the group.
     * @var string
     */
    public string $name;

    /**
     * Description of the group.
     * @var string
     */
    public string $description;

    /**
     * Total count of members in the group
     * @var int
     */
    public int $totalMembers;

    /**
     * Add members to group.
     *
     * @param array $data
     * @return array
     */
    public function addMembers(array $data): array
    {
        return $this->zoom->addMembers($this->id, $data);
    }

    /**
     * Delete group
     *
     * @return void
     */
    public function delete(): void
    {
        $this->zoom->deleteGroup($this->id);
    }

    /**
     * Delete a group member
     *
     * @param string $memberId Member Id.
     * @return void
     */
    public function deleteMember(string $memberId): void
    {
        $this->zoom->deleteMember($this->id, $memberId);
    }

    /**
     * List the members of the group.
     *
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Support\Repository
     */
    public function members(array $query = []): Repository
    {
        return $this->zoom->groupMembers($this->id, $query);
    }

    /**
     * Update a group member
     *
     * @param string $memberId Member Id.
     * @param array $data
     * @return void
     */
    public function updateMember(string $memberId, array $data): void
    {
        $this->zoom->updateMember($this->id, $memberId, $data);
    }

    /**
     * Update group
     *
     * @param array $data
     * @return void
     */
    public function update(array $data): void
    {
        $this->zoom->updateGroup($this->id, $data);
    }
}
