<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

/**
 * Role
 */
class Role extends Resource
{
    /**
     * Role Id.
     * @var string
     */
    public string $id;

    /**
     * Name of the role.
     * @var string
     */
    public string $name;

    /**
     * Description of the role.
     * @var string
     */
    public string $description;

    /**
     * Total members assigned to that role.
     * @var int
     */
    public int $totalMembers;

    /**
     * Privileges assigned to the role. Can be one or a combination of [these permissions]
     * (https://marketplace.zoom.us/docs/api-reference/other-references/privileges).
     *
     * @var array
     */
    public array $privileges;

    /**
     * This field will only be displayed to accounts that are enrolled in the
     * ISV API Partner Plan and follow Master Accounts and Sub Accounts structure.
     * @var array
     */
    public array $subAccountPrivileges;

    /**
     * Unassign a user’s role.
     *
     * @param array $data
     * @return array
     */
    public function assign(array $data): array
    {
        return $this->zoom->assignRole($this->id, $data);
    }

    /**
     * Delete a role
     *
     * @return void
     */
    public function delete(): void
    {
        $this->zoom->deleteRole($this->id);
    }

    /**
     * List all the members that are assigned a specific role.
     *
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Support\Repository
     */
    public function members(array $query = []): Repository
    {
        return $this->zoom->roleMembers($this->id, $query);
    }

    /**
     * Unassign a user’s role.
     *
     * @param string $memberId
     * @return void
     */
    public function unassign(string $memberId): void
    {
        $this->zoom->unassignRole($this->id, $memberId);
    }

    /**
     * Update a role
     *
     * @param array $data
     * @return void
     */
    public function update(array $data): void
    {
        $this->zoom->updateRole($this->id, $data);
    }
}
