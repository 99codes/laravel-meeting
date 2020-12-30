<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

/**
 * The user object represents a specific user on Zoom.
 */
class User extends Resource
{
    /**
     * User ID.
     * @var string
     */
    public string $id;

    /**
     * User's first name.
     * @var string
     */
    public string $firstName;

    /**
     * User's last name.
     * @var string
     */
    public string $lastName;

    /**
     * User's email address.
     * @var string
     */
    public string $email;

    /**
     * User's plan type:`1` - Basic.`2` - Licensed.`3` - On-prem.
     * @var int
     */
    public int $type;

    /**
     * User's [role](https://support.zoom.us/hc/en-us/articles/115001078646-Role-Based-Access-Control) name.
     * @var string
     */
    public string $roleName;

    /**
     * Personal meeting ID.
     * @var int
     */
    public int $pmi;

    /**
     * Use Personal Meeting ID for instant meetings.
     * @var bool
     */
    public bool $usePmi = false;

    /**
     * The time zone of the user.
     * @var string
     */
    public string $timezone;

    /**
     * Department.
     * @var string
     */
    public string $dept;

    /**
     * User create time.
     * @var string
     */
    public string $createdAt;

    /**
     * User last login time.
     * @var string
     */
    public string $lastLoginTime;

    /**
     * User last login client version.
     * @var string
     */
    public string $lastClientVersion;

    /**
     * Default language for the Zoom Web Portal.
     * @var string
     */
    public string $language;

    /**
     * User's country for Company Phone Number.
     * @var string
     */
    public string $phoneCountry;

    /**
     * User's phone number.
     * @var string
     */
    public string $phoneNumber;

    /**
     * Personal meeting room URL, if the user has one.
     * @var string
     */
    public string $vanityUrl;

    /**
     * User's personal meeting url.
     * @var string
     */
    public string $personalMeetingUrl;

    /**
     * Displays whether user is verified or not.
     * `1` - Account verified.
     * `0` - Account not verified.
     * @var int
     */
    public int $verified;

    /**
     * The URL for user's profile picture.
     * @var string
     */
    public string $picUrl;

    /**
     * CMS ID of user, only enabled for Kaltura integration.
     * @var string
     */
    public string $cmsUserId;

    /**
     * User's account ID.
     * @var string
     */
    public string $accountId;

    /**
     * User's host key.
     * @var string
     */
    public string $hostKey;

    /**
     * Status of user's account.
     * @var string
     */
    public string $status;

    /**
     * IDs of the web groups user belongs to.
     * @var array
     */
    public array $groupIds;

    /**
     * IM IDs of the groups user belongs to.
     * @var array
     */
    public array $imGroupIds;

    /**
     * jid
     * @var string
     */
    public string $jid;

    /**
     * User's job title.
     * @var string
     */
    public string $jobTitle;

    /**
     * User's company.
     * @var string
     */
    public string $company;

    /**
     * User's location.
     * @var string
     */
    public string $location;

    /**
     * Custom attribute(s) that have been assigned to the user.
     * @var array
     */
    public array $customAttributes;

    /**
     * Create a new meeting for the user
     *
     * @param array $data
     * @return Meeting
     */
    public function createMeeting(array $data): Meeting
    {
        return $this->zoom->createUserMeeting($this->id, $data);
    }

    /**
     * Delete a user
     *
     * @param array $query
     * @return void
     */
    public function delete(array $query = []): void
    {
        $this->zoom->deleteUser($this->id, $query);
    }

    /**
     * Update a user
     *
     * @param array $data
     * @param array $query
     * @return void
     */
    public function update(array $data, array $query = []): void
    {
        $this->zoom->updateUser($this->id, $data, $query);
    }

    /**
     * Update the user's email.
     *
     * @param array $data
     * @return void
     */
    public function updateEmail(array $data): void
    {
        $this->zoom->updateUserEmail($this->id, $data);
    }

    /**
     * Update the user's password.
     *
     * @param array $data
     * @return void
     */
    public function updatePassword(array $data): void
    {
        $this->zoom->updateUserPassword($this->id, $data);
    }

    /**
     * Update the user's status.
     *
     * @param array $data
     * @return void
     */
    public function updateStatus(array $data): void
    {
        $this->zoom->updateUserStatus($this->id, $data);
    }

    /**
     * Get the collection of user's meetings
     *
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Support\Repository
     */
    public function meetings(array $query = []): Repository
    {
        return $this->zoom->userMeetings($this->id, $query);
    }

    /**
     * Get the list of permissions for the user
     *
     * @return array
     */
    public function permissions(): array
    {
        return $this->zoom->userPermissions($this->id);
    }

    /**
     * Get the collection of recordings of a user
     *
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Support\Repository
     */
    public function recordings(array $query = []): Repository
    {
        return $this->zoom->userRecordings($this->id, $query);
    }
}
