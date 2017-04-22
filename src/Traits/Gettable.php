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
        // This is not an ApiResource, but we are checking for changed, which is
        // reserved for that class type. Bail early and save ourselves the processes.
        $noChangedProperty = !property_exists($this, 'changed');
        if ($name == 'changed' && $noChangedProperty) {
            return null;
        }
        
        // TODO: Revisit this logic. Not sure all the checks are necessary.
        // 
        // Exists with the same name as the one being evaluated. If it does, call
        // the method, set the instance variable, and then return the results.
        if (method_exists($this, $name)) {
            $changedExists = property_exists($this, 'changed');
            $changedNotNull = !is_null($this->changed);
            $changedProp = !isset($this->changed[$name]);
            $changedPropNotNull = !is_null($this->changed[$name]);
            if ($changedExists && $changedNotNull && $changedProp && $changedPropNotNull) {
            
                $this->changed[$name] = $this->$name();
                return $this->changed[$name];

            }
            return $this->$name();
        }        

        // Default returning changes being performed, not raw.
        if ($noChangedProperty && isset($this->changed[$name]) && !is_null($this->changed[$name])) {
            return $this->changed[$name];

        }

        // For all of our ApiResources, we capture the raw return of the API call
        // in a property called "raw", strangely enough. Check there.
        $rawExists = (property_exists($this, 'raw') && is_array($this->raw));
        if ($rawExists && array_key_exists($name, $this->raw)) {
// dd(array_key_exists($name, $this->raw));
            if (is_array($this->raw[$name])) {
dump('object: '. $name);                
                return (object) $this->raw[$name];
            }
dump('value: '. $name);
            return $this->raw[$name];

        }

        // Shouldn't be necessary, but it might be the case that someone has
        // set a property to null without having a method of that name;
        // therefore, we don't want to error out, we just return null.
        if (property_exists($this, 'changed') && isset($this->changed[$name]) && is_null($this->changed[$name])) {
            return null;

        }

        // Last ditch effort. Give it over to the class itself.
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . __CLASS__ .
            ' on line ' . __LINE__,
            E_USER_NOTICE);        
        return null; 
    }
}