<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Actions;

use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\Account;
use Nncodes\Meeting\Providers\Zoom\Sdk\Resources\CloudRecording;
use Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository;

trait ManagesAccounts
{
    /**
     * Get a Sub Account under the Master Account. Your account must be a Master Account in order to retrieve Sub Accounts.
     * Zoom only assigns this privilege to trusted partners and only approved partners can use this API.
     *
     * @param string $accountId The account ID.
     * @return Account
     */
    public function account(string $accountId): Account
    {
        return new Account($this->get("accounts/{$accountId}"), $this);
    }

    /**
     * List Cloud Recordings available on an Account.
     *
     * @param string $accountId The account ID.
     * @param array $query
     * @return \Nncodes\Meeting\Providers\Zoom\Sdk\Support\Repository
     */
    public function accountMeetingRecordings(string $accountId, array $query = []): Repository
    {
        $request = fn ($query, $paginator) => $this->transformCollection(
            $this->get("accounts/{$accountId}/recordings?" . http_build_query($query)),
            [CloudRecording::class, 'meetings'],
            $paginator
        );

        return $request($query, $request);
    }
}
