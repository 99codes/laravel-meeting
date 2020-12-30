<?php

namespace Nncodes\Meeting\Providers\Zoom\Sdk\Resources;

/**
 * Meeting Participant.
 */
class MeetingParticipant extends Resource
{
    /**
     * A valid email address of the registrant.
     * @var string
     */
    public string $email;

    /**
     * Registrant's first name.
     * @var string
     */
    public string $firstName;

    /**
     * Registrant's last name.
     * @var string
     */
    public string $lastName;

    /**
     * Registrant's address.
     * @var string
     */
    public string $address;

    /**
     * Registrant's city.
     * @var string
     */
    public string $city;

    /**
     * Registrant's country. The value of this field must be in two-letter abbreviated form and must match the ID field
     * provided in the [Countries](https://marketplace.zoom.us/docs/api-reference/other-references/abbreviation-lists#countries) table.
     * @var string
     */
    public string $country;

    /**
     * Registrant's Zip/Postal Code.
     * @var string
     */
    public string $zip;

    /**
     * Registrant's State/Province.
     * @var string
     */
    public string $state;

    /**
     * Registrant's Phone number.
     * @var string
     */
    public string $phone;

    /**
     * Registrant's Industry.
     * @var string
     */
    public string $industry;

    /**
     * Registrant's Organization.
     * @var string
     */
    public string $org;

    /**
     * Registrant's job title.
     * @var string
     */
    public string $jobTitle;

    /**
     * This field can be included to gauge interest of webinar attendees towards buying your product or service.
     * Purchasing Time Frame:`Within a month``1-3 months``4-6 months``More than 6 months``No timeframe`
     * @var string
     */
    public string $purchasingTimeFrame;

    /**
     * Role in Purchase Process:`Decision Maker``Evaluator/Recommender``Influencer``Not involved`
     * @var string
     */
    public string $roleInPurchaseProcess;

    /**
     * Number of Employees:`1-20``21-50``51-100``101-500``500-1,000``1,001-5,000``5,001-10,000``More than 10,000`
     * @var string
     */
    public string $noOfEmployees;

    /**
     * A field that allows registrants to provide any questions or comments that they might have.
     * @var string
     */
    public string $comments;

    /**
     * Custom questions.
     * @var array
     */
    public array $customQuestions;

    /**
     * Registrant's language preference for confirmation  emails. The value can be one of the following:
     * `en-US`,`de-DE`,`es-ES`,`fr-FR`,`jp-JP`,`pt-PT`,`ru-RU`,`zh-CN`, `zh-TW`, `ko-KO`, `it-IT`, `vi-VN`.
     * @var string
     */
    public string $language;

    /**
     * auto_approve
     * @var bool
     */
    public bool $autoApprove;
}
