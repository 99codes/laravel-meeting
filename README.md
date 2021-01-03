# Laravel Meeting

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nncodes/laravel-meeting.svg?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meeting)
[![License](https://img.shields.io/packagist/l/laravel/forge-sdk?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meeting)
[![Total Downloads](https://img.shields.io/packagist/dt/nncodes/laravel-meeting.svg?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meeting)

## Official Documentation

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation & setup](#installation-setup)
- [Preparing your models](#preparing-your-models)
    - [Scheduler](#scheduler)
    - [Presenter](#presenter)
    - [Host](#host)
    - [Participant](#participant)
- [Scheduling a meeting](#scheduling-a-meeting)
- [Retrieving meetings](#retrieving-meetings)
    - [Eloquent scopes](#eloquent-scopes)
- [Handling a scheduled meeting](#handling-a-scheduled-meeting)
    - [Meeting](#meeting)
    - [Participants](#participants)
    - [Hosts](#hosts)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security-vulnerabilities)
- [License](#license)

## Introduction

This package can handle online meetings with Eloquent models. It provides a simple, fluent API to work with and by default uses Zoom as provider.

```php
use Nncodes\Meeting\Models\Meeting;
use Nncodes\Meeting\Models\MeetingRoom;
use App\Models\Event;
use App\Models\Teacher;

$meeting = Meeting::schedule()
  	->withTopic('English class: verb to be')
  	->startingAt(now()->addMinutes(30))
  	->during(40) //in Minutes
  	->scheduledBy(Event::find(1))
  	->presentedBy(Teacher::find(1))
  	->hostedBy(MeetingRoom::find(1))
  	->save();
```

## Requirements

This package requires PHP 7.3+ and Laravel 6+.

This package uses [`nncodes/meta-attributes`](https://github.com/99codes/laravel-meta-attributes) to attach meta attributes to the models.

## Installation & setup

You can install the package via composer:

```bash
composer require nncodes/laravel-meeting
```

The package will automatically register itself.

You can use the `meeting:install` command to publish the migrations and use `--config` if you also want to publish the config file.

```bash
php artisan meeting:install --config
```

Or you can publish by the traditional way:

```bash
php artisan vendor:publish --provider="Nncodes\Meeting\MeetingServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Nncodes\MetaAttributes\MetaAttributesServiceProvider" --tag="migrations"
```

After the migration has been published you can create the tables by running the migrations:

```bash
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Nncodes\Meeting\MeetingServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
/**
 * Default Meeting Provider
 * 
 * Here you can specify which meeting provider the package should use by 
 * default. Of course you may use many providers at once using the package.
 */
'default' => env('MEETING_PROVIDER', 'zoom'),

/**
 * Meeting Providers
 * 
 * Here are each of the meetings provider setup for the package.
 */

'providers' => [

    'zoom' => [

         /**
         * Provider class
         **/
        'type' => \Nncodes\Meeting\Providers\Zoom\ZoomProvider::class,

        /**
         * JWT Zoom Token 
         * @see https://marketplace.zoom.us/docs/guides/auth/jwt
         **/
        'jwt_token' => env('ZOOM_TOKEN'),

        /**
         * Zoom Group ID
         * 
         * @see https://marketplace.zoom.us/docs/api-reference/zoom-api/groups/group
         **/
        'group_id' => env('ZOOM_GROUP'),

         /**
         * Share Rooms
         * 
         * Delegate to the package the responsability of handling the allocations of rooms.
         **/
        'share_rooms' => true,

         /**
         * Meeting resource seetings
         * 
         * @see https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meeting
         **/
        'meeting_settings' => [
            "host_video" => false,
            "participant_video" => false,
            "join_before_host" => false,
            "jbh_time" => 0,
            "mute_upon_entry" => true,
            "approval_type" => 0,
            "registration_type" => 1,
            "close_registration" => true,
            "waiting_room" => true,
            "registrants_confirmation_email" => false,
            "registrants_email_notification" => false,
            "meeting_authentication" => false
        ]
    ]
],

/**
 * Allow concurrent Meetings
 */
'allow_concurrent_meetings' => [
    'host' => false,
    'participant' => false,
    'presenter' => false,
    'scheduler' => true,
]
```

## Preparing your models

### Scheduler 

Responsible for scheduling the meeting, the model must implement the following interface and trait:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nncodes\Meeting\Concerns\SchedulesMeetings;
use Nncodes\Meeting\Contracts\Scheduler;

class Event extends Model implements Scheduler
{
    use SchedulesMeetings;
}
```

### Presenter

Responsible for present the meeting, the model must implement the following interface and trait:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nncodes\Meeting\Concerns\PresentsMeetings;
use Nncodes\Meeting\Contracts\Presenter;

class Teacher extends User implements Presenter
{
    use PresentsMeetings;
}
```

### Host

Responsible for hosting the meeting, the model must implement the following interface and trait:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nncodes\Meeting\Concerns\HostsMeetings;
use Nncodes\Meeting\Contracts\Host;

class Room extends Model implements Host
{
    use HostsMeetings;
}
```

### Participant

Allowed to join a meeting, the model must implement the following interface, trait and the `getEmailAddress`, `getFirstName` and `getLastName` methods:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nncodes\Meeting\Concerns\JoinsMeetings;
use Nncodes\Meeting\Contracts\Participant;

class Student extends User implements Participant
{
    use JoinsMeetings;

    /**
     * Email Address of the participant
     *
     * @return string
     */
    public function getParticipantEmailAddress(): string
    {
        return $this->email;
    }

    /**
     * First name of the participant
     *
     * @return string
     */
    public function getParticipantFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * Last name of the participant
     *
     * @return string
     */
    public function getParticipantLastName(): string
    {
        return $this->last_name;
    }
}
```

## Scheduling a meeting

To schedule a meeting you need to use the methods below to properly fill the meeting data:

```php
use Nncodes\Meeting\Models\Meeting;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Room;

$event = Event::find(1);
$teacher = Teacher::find(1);
$room = Room::find(1);

$meeting = Meeting::schedule()
  	->withTopic('English class: verb to be')
  	->startingAt(now()->addMinutes(30))
  	->during(40) //minutes
  	->scheduledBy($event)
  	->presentedBy($teacher)
  	->hostedBy($room)
  	->save();
```

Or you can also schedule by the `scheduler` model:

```php
use Nncodes\Meeting\Models\Meeting;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Room;

$event->scheduleMeeting()
  	->withTopic('English class: verb to be')
  	->startingAt(now()->addMinutes(30))
  	->during(40) //minutes
  	->presentedBy($teacher)
  	->hostedBy($room)
  	->save()
```

Of course if needed, you can update the meeting: 

```php
use Nncodes\Meeting\Models\Meeting;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Room;

$meeting = Meeting::find(1);

$meeting->updateTopic('English class: Introducing Yourself')
    ->updateDuration(60)
    ->updateStartTime(now())
    ->updateScheduler(Event::find(1))
    ->updatePresenter(Teacher::find(5))
    ->updateHost(Room::find(1))
    ->save();
```

Then you can add a participant:

```php
use Nncodes\Meeting\Models\Meeting;
use App\Models\Student;

$meeting = Meeting::find(1);
$student = Student::find(1);

//By the meeting model
$meeting->addParticipant($student);

//Or by the participant model 
$student->bookMeeting($meeting);
```

To provide the access to the presenter use:

```php
use Nncodes\Meeting\Models\Meeting;

Meeting::find(1)->getPresenterAccess();
```

And for the participant use:

```php
use Nncodes\Meeting\Models\Meeting;
use App\Models\Student;

$student = Student::find(1);

Meeting::find(1)>getParticipantAccess($student);
```

More: [handling a scheduled meeting](#handling-a-scheduled-meeting).

## Retrieving meetings

**You can just call from the meeting model:**

Scoping meetings by `Nncodes\Meeting\Models\Meeting`.
```php
$query = Meeting::query();
```

**or call `meetings()` from any actor:**

Scoping meetings from scheduler model, e.g. `App\Models\Event` with `id:1`.
```php
$query = Event::find(1)->meetings();
```

Scoping meetings from presenter model, e.g. `App\Models\Teacher` with `id:1`.
```php
$query = Teacher::find(1)->meetings();
```

Scoping meetings from host model, e.g. `App\Models\Room` with `id:1`.
```php
$query = Room::find(1)->meetings();
```

Scoping meetings from participant model, e.g. `App\Models\Student` with `id:1`.
```php
$query = Student::find(1)->meetings();
```

### Eloquent scopes

**General scopes**

scoping by `uuid`, e.g `b33cac3a-c8da-4b33-a296-30a6acff5af6`.
```php
$query->byUuid('b33cac3a-c8da-4b33-a296-30a6acff5af6');
```

scoping by `id`, e.g `1`.
```php
$query->byId(1);
```

scoping by provider, e.g. `zoom`.
```php
$query->provider('zoom');
```

**Scopes for `start_time`, `started_at` and `ended_at`**

scoping by start time from, e.g. `15 days ago`.
```php
$query->startsFrom(Carbon::now()->sub('15 days'));
```

scoping by start time until, e.g. `15 days from now`.
```php
$query->startsUntil(Carbon::now()->add('15 days'));
```

Or scoping by start time within a period, e.g. from `15 days ago` and `15 days from now`.
```php
$query->startsBetween(
    Carbon::now()->sub('15 days'),
    Carbon::now()->add('15 days')
);
```

scoping by status `live`, the started but not ended meetings.
```php
$query->live();
```

scoping by status `past`, the started and ended meetings.
```php
$query->past();
```

scoping by status `scheduled`, the not started meetings.
```php
$query->scheduled();
```

scoping by `scheduled` status and where `start_time` is past. Queries the late to start meetings.
```php
$query->late();
```

scoping by `live` status and where `started_at` + `duration` is past. Queries the meetings that had exceeded the scheduled duration.
```php
$query->exceeded();
```

scoping by `scheduled` status ordering by `start_time` asc. Queries the next neetings
```php
$query->next();
```

scoping by `last` status ordering by `ended_at` desc queries the last meetings
```php
$query->last();
```

**Scopes for actors**

scoping by scheduler, e.g. `App\Models\Event` with `id:1`.
```php
$query->scheduler(Event::find(1));
```

scoping by host, e.g. `App\Models\Room` with `id:1`.
```php
$query->host(Room::find(1));
```

scoping by participant, e.g. `App\Models\Student` with `id:1`.
```php
$query->participant(Student::find(1));
```

scoping by presenter, e.g. `App\Models\Teacher` with `id:1`.
```php
$query->presenter(Teacher::find(1));
```

Finally to retrieve the data you can call any eloquent retriever method, e.g. `count`, `first`, `get`, `paginate` and etc.


## Handling a scheduled meeting

### Meeting

When using zoom provider, you can set `share_rooms` to `true`, then you don't need to inform a host when scheduling a meeting. The package handles the allocation of rooms.

In this case you can schedule using: 

```php
use Nncodes\Meeting\Models\Meeting;
use App\Models\Event;
use App\Models\Teacher;

$meeting = Meeting::schedule()
  	->withTopic('English class: verb to be')
  	->startingAt(now()->addMinutes(30))
  	->during(40) //minutes
  	->scheduledBy(Event::find(1))
  	->presentedBy(Teacher::find(1))
  	->save();
```

If no rooms is available the expcetion `\Nncodes\Meeting\Exceptions\NoZoomRoomAvailable` is thrown.

```php 
use Nncodes\Meeting\Models\Meeting;
```

Starting a meeting.
```php
Meeting::find(1)->start();
```

Ending a meeting.
```php
Meeting::find(1)->end();
```

Canceling a meeting.
```php
Meeting::find(1)->cancel();
```

### Participants

#### Add a participant

Adding a participant by `Nncodes\Meeting\Models\Meeting`
```php
$student = Student::find(1);
Meeting::find(1)->addParticipant($student);
```

Adding a participant by participant model `App\Models\Student`
```php
$meeting = Meeting::find(1);
Student::find(1)->bookMeeting($meeting);
```

#### Cancel a participation

Canceling a participation by `Nncodes\Meeting\Models\Meeting`
```php
$student = Student::find(1);
Meeting::find(1)->cancelParticipation($student);
```

Adding a participant by participant model `App\Models\Student`
```php
$meeting = Meeting::find(1);
Student::find(1)->cancelMeetingParticipation($meeting);
```

#### Join meeting

Joining by `Nncodes\Meeting\Models\Meeting`
```php
$student = Student::find(1);
Meeting::find(1)->joinParticipant($student);
```

Joining by participant model `App\Models\Student`
```php
$meeting = Meeting::find(1);
Student::find(1)->joinMeeting($meeting);
```

##### Leave meeting

Leaving by `Nncodes\Meeting\Models\Meeting`
```php
$student = Student::find(1);
Meeting::find(1)->leaveParticipant($student);
```

Leaving by participant model `App\Models\Student`
```php
$meeting = Meeting::find(1);
Student::find(1)->leaveMeeting($meeting);
```

##### Getting participants

Getting a participant

```php
$student = Student::find(1);
$participant = Meeting::find(1)->participant($student);
```

Checking if a meeting has a participant:

```php
$student = Student::find(1);
$bool = Meeting::find(1)->hasParticipant($student);
```

Getting a list of participants using the morphMany relationship:

```php
//Must inform the participant model type
$participants = Meeting::find(1)->participants(App\Models\Student::class)->get();
```

Or using the participantsPivot relation. 

```php
//Doesn't need to inform participant model type, it gets all types. 
$participants = Meeting::find(1)->participantsPivot;
```

Getting the first participant ordering by `created_at` desc, it allows to use a meeting as queue mode service.
```php
$participant = Meeting::find(1)->getNextParticipant();
```

### Hosts

#### Scoping and verification methods

Given the code: 

```php
use Nncodes\Meeting\Models\MeetingRoom;

$startTime = Carbon::now()->addMinutes(30);
$duration = 40;
$endTime = (clone $startTime)->addMinutes($duration);
```

Scoping an available host:
```php 
MeetingRoom::availableBetween($startTime, $endTime);
```

Scoping a busy host:
```php 
MeetingRoom::busyBetween($startTime, $endTime);
```

Scoping busy and available hosts except for a meeting
```php 
use Nncodes\Meeting\Models\Meeting;

$except = Meeting::find(1);

MeetingRoom::availableBetween($startTime, $endTime, $except);
MeetingRoom::busyBetween($startTime, $endTime, $except);
```

Then you can call any eloquent retriever method, e.g. `count`, `first`, `get`, `paginate` and etc.

You can also check if a room instance is busy or available:

```php 
use Nncodes\Meeting\Models\MeetingRoom;

MeetingRoom::find(1)->isAvailableBetween($startTime, $endTime);
MeetingRoom::find(1)->isBusyBetween($startTime, $endTime);
```

As the scope methods, you can also specify meeting to exclude from the query:

```php 
use Nncodes\Meeting\Models\MeetingRoom;
use Nncodes\Meeting\Models\Meeting;

$except = Meeting::find(1);

MeetingRoom::find(1)->isAvailableBetween($startTime, $endTime, $except);
MeetingRoom::find(1)->isBusyBetween($startTime, $endTime, $except);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Leonardo Poletto](https://github.com/leopoletto)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
