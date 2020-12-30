<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Actions;

use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Role;
use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\User;
use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

trait ManagesRoles
{
    /**
     * Unassign a user’s role.
     *
     * @param string $roleId
     * @param array $data
     * @return array
     */
    public function assignRole(string $roleId, array $data): array
    {
        return $this->post("roles/{$roleId}/members", $data);
    }

    /**
     * Create a new role
     *
     * @param array $data
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Role
     */
    public function createRole(array $data): Role
    {
        return new Role($this->post("roles", $data), $this);
    }

    /**
     * Delete a role
     *
     * @param string $roleId Role Id.
     * @return void
     */
    public function deleteRole(string $roleId): void
    {
        $this->delete("roles/{$roleId}");
    }

    /**
     * Get a instance of role
     *
     * @param string $roleId
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Role
     */
    public function role(string $roleId): Role
    {
        return new Role($this->get("roles/{$roleId}"), $this);
    }

    /**
     * List all the members that are assigned a specific role.
     *
     * @param string $roleId
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function roleMembers(string $roleId, array $query = []): Repository
    {
        $request = fn ($query, $paginator) => $this->transformCollection(
            $this->get("roles/{$roleId}/members?".http_build_query($query)),
            [User::class, 'members'],
            $paginator
        );

        return $request($query, $request);
    }

    /**
     * Get the collection of roles.
     *
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function roles(): Repository
    {
        return $this->transformCollection(
            $this->get("roles"),
            [Role::class, 'roles']
        );
    }

    /**
     * Unassign a user’s role.
     *
     * @param string $roleId The role ID
     * @param string $memberId Member's ID
     * @return void
     */
    public function unassignRole(string $roleId, string $memberId): void
    {
        $this->delete("roles/{$roleId}/members/{$memberId}");
    }

    /**
     * Update a role
     *
     * @param string $roleId
     * @param array $data
     * @return void
     */
    public function updateRole(string $roleId, array $data): void
    {
        $this->patch("roles/{$roleId}", $data);
    }
}
