# Eventbrite SDK for PHP from 8fold

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

// to get all the events owned by the entity related to the auth token
GET /users/:id/owned_events
```

Translates to:

```php
// creates an Organization object
$eb = Eventbrite::setAuthToken(YOUR_AUTH_TOKEN, true);

// to get all the organizers
$eb->entity->organizers

// to get all the events owned by the entity related to the auth token
$eb->entity->events;
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
$event = Event::find(:id, Eventbrite);
```

POST /events/:id/

NOTE: Eventbrite does not currently suppot PATCH or PUT; however, the SDK only transmits the properties that were changed since the last save. If you never save, you are not affecting the Event stored with Eventbrite.

```php
$event = Event::find(:id, Eventbrite);
$event->name_html = 'Oh, hi Mark.';
$event->save();
```

### Ticket Classes

GET /events/:id/ticket_classes/

```php
$event = Event::find(:id, Eventbrite);
$ticketClasses = $event->ticketClasses;
```

POST /events/:id/ticket_classes/

```php
$event = Event::find(:id, Eventbrite);
$ticket_classes = $event->ticketClasses;
```

GET /events/:id/ticket_classes/:ticket_class_id/

```php
$event = Event::find(:id, Eventbrite);
$ticketClass = $event->ticketClassWithId(:ticket_class_id);

// OR

$ticketClass = TicketClass::find($event, :ticket_class_id);
```

POST /events/:id/ticket_classes/:ticket_class_id/

```php
$event = Event::find(:id, Eventbrite);
$ticket_classes = $event->ticket_classes;
$ticketClass = $ticket_classes[0];
$ticketClass->cost = 2000; // USD only right now
$ticketClass->save();
```

### Discounts

GET /events/:id/discounts/

```php
$event = Event::find(:id, Eventbrite);
$discounts = $event->discounts;
```

GET /events/:id/discounts/:discount_id/

```php
$event = Event::find(:id, Eventbrite);
$discount = $event->ticketClassWithId(:discount_id);

// OR

$discount = TicketClass::find($event, :discount_id);
```

## Event todo

GET /events/search/

POST /events/:id/publish/

POST /events/:id/unpublish/

POST /events/:id/cancel/

DELETE /events/:id/

GET /events/:id/display_settings/

POST /events/:id/display_settings/

DELETE /events/:id/ticket_classes/:ticket_class_id/

GET /events/:id/canned_questions/

GET /events/:id/questions/

GET /events/:id/questions/:id/

GET /events/:id/attendees/

GET /events/:id/attendees/:attendee_id/

GET /events/:id/orders/

POST /events/:id/discounts/

POST /events/:id/discounts/:discount_id/

GET /events/:id/public_discounts/

POST /events/:id/public_discounts/

GET /events/:id/public_discounts/:discount_id/

POST /events/:id/public_discounts/:discount_id/

DELETE /events/:id/public_discounts/:discount_id/

GET /events/:id/access_codes/

POST /events/:id/access_codes/

GET /events/:id/access_codes/:access_code_id/

POST /events/:id/access_codes/:access_code_id/

GET /events/:id/transfers/

GET /events/:id/teams/

GET /events/:id/teams/:id/

GET /events/:id/teams/:id/attendees/