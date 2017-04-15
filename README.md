# Eventbrite SDK for PHP from 8fold

## Composer install

```
"require": {
 "8fold/eventbrite-sdk-php": "*"
}
```

## Description

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