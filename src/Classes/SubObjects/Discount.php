<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\SubObjects\EventSub;

/**
 * @package EventSub alias
 */
class Discount extends EventSub
{
    /**
     * POST /events/:id/discounts/|POST /events/:id/public_discounts/
     *
     * POST /events/:id/discounts/ - Creates a new discount; returns the result as a
     *                               discount as the key discount.
     *
     * POST /events/:id/public_discounts/ - Creates a new public discount; returns the
     *                                      result as a discount as the key discount.
     *
     * @return [type] [description]
     *
     * @todo Implement and test
     */
    static public function withOptions($options = [], $public = false)
    {

    }

    /**
     * POST /events/:id/discounts/:discount_id/ - Updates a discount; returns the
     *                                            result as a discount as the key
     *                                            discount.
     *
     * POST /events/:id/public_discounts/:discount_id/ - Updates a public discount;
     *                                                   returns the result as a
     *                                                   discount as the key discount.
     *
     * @return [type] [description]
     *
     * @todo Consider creating a second class - PublicDiscount as Eventbrite
     *       differentiates between the two.
     */
    public function update()
    {

    }

    /**
     * DELETE /events/:id/public_discounts/:discount_id/ - Deletes a public discount.
     *
     * @return [type] [description]
     */
    public function delete()
    {

    }
}
