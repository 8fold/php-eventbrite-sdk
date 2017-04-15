<?php

namespace Eightfold\Eventbrite\Traits;

/**
 * Uses PHP's __get() magic method to allow calculated properties.  
 */
trait Gettable
{
    /**
     * Do not call directly!
     * 
     * Override the default PHP getter for classes inheriting this trait. Allows
     * you to create methods, which can be used like properties as well as
     * giving us access to the properties of the Eventbrite return JSON.
     *
     * PHP will automatically call this method for you. Therefore, do not call this
     * method directly.
     *
     * @param  string    $name The name of the property being attempted.
     * @return variable        The raw property, the set property, the result of a
     *                         a method call, or an error message.
     */
    public function __get(string $name)
    {
        // For all of our ApiResources, we capture the raw return of the API call
        // in a property called "raw", strangely enough. Check to see if what
        // we are looking for is hiding in there and return early, if so.
        if (isset($this->raw) && array_key_exists($name, $this->raw)) {
            return $this->raw[$name];

        }

        // Some of the properties are the result of an API call. We don't want to
        // be too chatty with the API lest we hit the throttle limit; therefore
        // we will check to see if we've already set an instance property.
        if (isset($this->{$name}) && !is_null($this->{$name})) {
            return $this->{$name};

        }

        // This is the last ditch effort to find something. Check to see if a method
        // exists with the same name as the one being evaluated. If it does, call
        // the method, set the instance variable, and then return the results.
        if (method_exists($this, $name)) {
            $this->{$name} = $this->$name();
            return $this->{$name};

        }

        // Shouldn't be necessary, but it might be the case that someone has
        // set a property to null without having a method of that name;
        // therefore, we don't want to error out, we just return null.
        if (isset($this->{$name}) && is_null($this->{$name})) {
            return null;

        }        

        // We have failed. Print error message and return nothing.
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . __CLASS__ .
            ' on line ' . __LINE__,
            E_USER_NOTICE);
        return null; 
    }
}