<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

/**
 * Account
 */
class Account extends Resource
{
    /**
     * Account ID.
     * @var string
     */
    public string $id;

    /**
     * Account owner ID.
     * @var string
     */
    public string $ownerId;

    /**
     * Account owner email.
     * @var string
     */
    public string $ownerEmail;

    /**
     * Account creation date and time.
     * @var string
     */
    public string $createdAt;

    /**
     * Account options object.
     * @var array
     */
    public array $options;

    /**
     * Account Vanit URL
     * @var string
     */
    public string $vanityUrl;

    /**
     * List Cloud Recordings available on an Account.
     *
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function recordings(array $query = []): Repository
    {
        return $this->zoom->accountMeetingRecordings($this->id, $query);
    }
}
