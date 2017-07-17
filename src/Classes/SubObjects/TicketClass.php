<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\SubObjects\EventSub;

/**
 * @package EventSub alias
 */
class TicketClass extends EventSub
{
    /**
     * POST /events/:id/ticket_classes/ - Creates a new ticket class, returning the
     *                                    result as a ticket_class under the key
     *                                    ticket_class.
     *
     * @return [type] [description]
     */
    static public function withOptions()
    {

    }

    /**
     * POST /events/:id/ticket_classes/:ticket_class_id/ - Updates an existing ticket
     *                                                     class, returning the
     *                                                     updated result as a
     *                                                     ticket_class under the key
     *                                                     ticket_class.
     *
     * @return [type] [description]
     */
    public function update()
    {

    }

    /**
     * DELETE /events/:id/ticket_classes/:ticket_class_id/ - Deletes the ticket class.
     *                                                       Returns {"deleted": true}.
     *
     * @return [type] [description]
     */
    public function delete()
    {

    }
}
