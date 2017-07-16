<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

use Eightfold\Eventbrite\Classes\SubObjects\ContactCollection;

/**
 * @package ApiResource alias
 */
class ContactList extends ApiResource
{
    /**
     * POST /users/:id/contact_lists/ - Makes a new contact_list for the user and
     *                                  returns it as contact_list.
     *
     * @param  array  $parameters [description]
     * @return [type]             [description]
     *
     * @todo Implement POST functionality.
     */
    static public function withParameters($parameters = [])
    {

    }

    /**
     * POST /users/:id/contact_lists/:contact_list_id/ - Updates the contact_list and
     *                                                   returns it as contact_list.
     *
     * @return [type] [description]
     */
    public function update()
    {

    }

    /**
     * DELETE /users/:id/contact_lists/:contact_list_id/ - Deletes the contact list.
     *                                                     Returns {"deleted": true}.
     *
     * @return [type] [description]
     */
    public function delete()
    {

    }

    /**
     * GET /users/:id/contact_lists/:contact_list_id/contacts/ - Returns the contacts
     *                                                           on the contact list
     *                                                           as contacts.
     *
     * @return [type] [description]
     */
    public function contacts()
    {

    }
}
