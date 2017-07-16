# Eventbrite SDK for PHP by 8fold

***Warning:** I am redoing the architecture for this library. I believe the abstraction has gone so far as to make the library unknownable by many developers, which can happen (too abstract and not concrete enough to pick up quickly). Some of the clever decisions might be worthwhile and will be kept, but I think making things a bit more concrete and straightforward is also worthwhile. If you have some recommendations or contributions, please feel free. Also working on creating unit tests, because, quite frankly, I stepped away to develop some other things for 8fold and, when I came back, I had no idea how the library works. :) Never a good sign.*

The Eventbrite SDK by 8fold strives to be a simple and complete wrapper for interfacing with the version 3 of the Eventbrite API. 

Note: Eventbrite has an official SDK of the same name.

Design considerations:

- **Convention over configuration:** When patterns present themselves, promote them to higher level objects and methods to allow you to avoid having to fill in a lot of method parameters in order to get up and running with the library.
- **Only call when you have to:** The API has a throttle (a maximum number of calls that can be performed within a specific period of time); therefore, the library minimizes the number of calls made by way of caching values locally. It will be more to you, the developer, to state whether you want to call the API again or not.
- 

## Composer install

```
"require": {
 "8fold/eventbrite-sdk-php": "*"
}
```

## Overview

This library is designed to mirror the Eventbrite API documentation when it comes to defining what is in each class definition. For example:

```bash
// to get all the organizers
GET /users/:id/organizers/

// to get all the events owned by the user
GET /users/:id/owned_events
```

Translates to:

```php
// creates an Organization object
$eb = Eventbrite::setAuthToken(YOUR_AUTH_TOKEN, true);

// to get all the organizers
$eb->user->organizers

// to get all the events owned by the user
$eb->user->events;
```

## Details Events

POST /events/

```php
// TODO: Verify
$event = new Event();
$event->name_html      = 'Hello world!';
$event->start_utc      = '2017-01-01T01:00:00Z';
$event->start_timezone = 'America/New York';
$event->end_utc        = '2017-01-02T01:00:00Z';
$event->end_timezone   = 'America/New York';
$event->currencty      = 'USD';
$event->save();
```

GET /events/:id/

```php
$event = Event::find(Eventbrite, :id);
```

POST /events/:id/

NOTE: Eventbrite does not currently suppot PATCH or PUT; however, the SDK only transmits the properties that were changed since the last save. If you never save, you are not affecting the Event stored with Eventbrite.

```php
$event = Event::find(Eventbrite, :id);
$event->name_html = 'Oh, hi Mark.';
$event->save();
```

### Ticket Classes

GET /events/:id/ticket_classes/

```php
$event = Event::find(Eventbrite, :id);
$ticketClasses = $event->ticketClasses;
```

POST /events/:id/ticket_classes/

```php
$event = Event::find(Eventbrite, :id);
$ticket_classes = $event->ticketClasses;
```

GET /events/:id/ticket_classes/:ticket_class_id/

```php
$event = Event::find(Eventbrite, :id);
$ticketClass = $event->ticketClassWithId(:ticket_class_id);

// OR

$ticketClass = TicketClass::find($event, :ticket_class_id);
```

POST /events/:id/ticket_classes/:ticket_class_id/

```php
$event = Event::find(Eventbrite, :id);
$ticket_classes = $event->ticket_classes;
$ticketClass = $ticket_classes[0];
$ticketClass->cost = 2000; // USD only right now
$ticketClass->save();
```

### Discounts

GET /events/:id/discounts/

```php
$event = Event::find(Eventbrite, :id);
$discounts = $event->discounts;
```

GET /events/:id/discounts/:discount_id/

```php
$event = Event::find(Eventbrite, :id);
$discount = $event->ticketClassWithId(:discount_id);

// OR

$discount = TicketClass::find($event, :discount_id);
```

### Display Settings

GET /events/:id/display_settings/

```php
$event = Event::find(Eventbrite, :id);
$displaySettings = $event->display_settings;
```

### Access codes

GET /events/:id/access_codes/

```php
$event = Event::find(Eventbrite, :id);
$accessCodes = $event->access_codes;
```

### Attendees

GET /events/:id/attendees/

```php
$event = Event::find(Eventbrite, :id);
$attendees = $event->attendees;
```

## Event todo

GET /events/search/

POST /events/:id/publish/

POST /events/:id/unpublish/

POST /events/:id/cancel/

DELETE /events/:id/

POST /events/:id/display_settings/

DELETE /events/:id/ticket_classes/:ticket_class_id/

GET /events/:id/canned_questions/

GET /events/:id/questions/

GET /events/:id/questions/:id/

GET /events/:id/attendees/:attendee_id/

GET /events/:id/orders/

POST /events/:id/discounts/

POST /events/:id/discounts/:discount_id/

GET /events/:id/public_discounts/

POST /events/:id/public_discounts/

GET /events/:id/public_discounts/:discount_id/

POST /events/:id/public_discounts/:discount_id/

DELETE /events/:id/public_discounts/:discount_id/

POST /events/:id/access_codes/

GET /events/:id/access_codes/:access_code_id/

POST /events/:id/access_codes/:access_code_id/

GET /events/:id/transfers/

GET /events/:id/teams/

GET /events/:id/teams/:id/

GET /events/:id/teams/:id/attendees/

## Performance considerations

Call once (caching). Call only when necessary (lazy-loading).

The Eventbrite SDK from 8fold is designed to only call the API when necessary and cache the results whenever possible.

This is good, and bad, because it means performance gains to the end user and the potential of becoming out of sync. However, given the server-side nature, and the hope that you are not doing anything too intense (delivering a page to an end-user), the possibility should be minimal.
