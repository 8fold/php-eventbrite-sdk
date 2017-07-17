<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\SubObjects\EventSub;

/**
 * @package EventSub alias
 */
class AccessCode extends EventSub
{
    /**
     * POST /events/:id/access_codes/ - Creates a new access code; returns the result
     *                                  as a access_code as the key access_code.
     *
     * @return [type] [description]
     */
    static public function withOptions()
    {

    }

    /**
     * POST /events/:id/access_codes/:access_code_id/ - Updates an access code;
     *                                                  returns the result as a
     *                                                  access_code as the key
     *                                                  access_code
     *
     * @return [type] [description]
     *
     * @todo Test and implement
     */
    public function update()
    {

    }
}
