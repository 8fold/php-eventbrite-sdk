<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

/**
 * @package ApiResource alias
 */
class Contact extends ApiResource
{
    /**
     * POST /users/:id/contact_lists/:contact_list_id/contacts/ - Adds a new contact
     *                                                            to the contact list.
     *                                                            Returns {"created":
     *                                                            true}. There is no
     *                                                            way to update
     *                                                            entries in the list;
     *                                                            just delete the old
     *                                                            one and add the
     *                                                            updated version.
     *
     * @param  [type] $userId        [description]
     * @param  [type] $contactListId [description]
     * @param  [type] $parameters    [description]
     * @return [type]                [description]
     *
     * @todo Implement POST functionality.
     */
    static public function withParameters($userId, $contactListId, $parameters)
    {

    }

    /**
     * DELETE /users/:id/contact_lists/:contact_list_id/contacts/ - Deletes the
     *                                                              specified contact
     *                                                              from the contact
     *                                                              list. Returns
     *                                                              {"deleted": true}.
     *
     * @return [type] [description]
     */
    public function delete()
    {

    }
}
