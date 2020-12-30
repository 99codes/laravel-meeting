# Laravel Meeting

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nncodes/laravel-meeting.svg?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meeting)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/99codes/laravel-meeting/run-tests?label=tests)](https://github.com/nncodes/laravel-meeting/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/nncodes/laravel-meeting.svg?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meeting)


Handle any kind of meeting with Laravel

## Installation

You can install the package via composer:

```bash
composer require nncodes/laravel-meeting
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Nncodes\Meeting\MeetingServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Nncodes\Meeting\MeetingServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
namespace App;

use Carbon\Carbon;
use Nncodes\Meeting\Models\Meeting;

$from = Carbon::now()->sub('15 days');
$to = Carbon::now()->add('15 days');

$student = Student::first();
$address = Address::first();
$teacher = Teacher::first();
$event = Event::first();


//Schedule a meeting from meeting model
// Meeting::schedule()
//   	->withTopic($event->topic)
//   	->startingAt($event->starts_at)
//   	->during(rand(20, 60))
//   	->scheduledBy($event)
//   	->presentedBy($teacher)
//   	->hostedBy($address)
//   	->save()

$meeting = Meeting::find(1)->start_time->utc()->format('Y-m-d\TH:i:se');

// //Schedule a meeting from scheduler model
// $event->scheduleMeeting()
//   	->withTopic($event->topic)
//   	->startingAt($event->starts_at)
//   	->during(rand(20, 60))
//   	->presentedBy($teacher)
//   	->hostedBy($address)
//   	->save()



// // //Updating a meeting.
// $meeting->updateTopic('Introducing Yourself')
//   	->updateDuration(60)
//   	->updateStartTime(now())
//   	->updateScheduler(Event::find(1))
//   	->updatePresenter(Teacher::find(5))
//   	->updateHost(Address::find(1))
//   	->save();
  
// //Retrieves a collection of meetings. Works for any actor.
// //In meeting model use Meeting:query()->presenter...

// $meeting = $address->meetings()
//   	->presenter(Teacher::find(5))
//   	->scheduler(Event::find(1))
//   	->provider('starter')
//   	->startsFrom($from)
//   	->startsUntil($to)
//   	//or ->startsBetween($from, $to)
//   	->first();

// //Retrieving the next meeting using meeting model
// $meeting = Meeting::scheduled()->orderBy('start_time', 'asc')->first();
// //Or
// $meeting = Meeting::next()->firstOrFail();

// //Starting a Meeting
// $meeting->start();

// //Adding a participant to a meeting
// $meeting->addParticipant($student);
// $meeting->joinParticipant($student);
// $meeting->leaveParticipant($student);
// $meeting->cancelParticipation($student);

// //Or
// $student->bookMeeting($meeting);
// $student->joinMeeting($meeting);
// $student->leaveMeeting($meeting);
// $student->cancelMeetingParticipation($meeting);

// //Ending a meeting
// $meeting->end();

// //Cancel a meeting
// $meeting->cancel();

// //Retrieving the last meeting using meeting model
// $meeting = Meeting::past()->orderBy('started_at', 'desc')->first();
// //Or
// $meeting = Meeting::last()->firstOrFail();

// //Retrieving the live meetings using meeting model
// $liveMeetings = Meeting::live()->get();

// //all scopes methods works inside the relations. Eg.
$scheduler->meetings()->live()->first();
$host->meetings()->past->get();
$presenter->meetings()->scheduled()->first();
$participant->meetings()->next()->first();

```

## Usage


## Testing

```bash
composer test
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
