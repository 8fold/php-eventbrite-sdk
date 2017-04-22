<?php

namespace Eightfold\Eventbrite\Traits;

trait Relateable 
{
    /**
     * Convert expansions to instances
     *
     * Used when creating getter methods that, in turn, get other objects from the
     * API. If an instance variable denoted with an underscore is already in place
     * then that object will be returned. If there is a raw value for the key, then
     * an instance of class will be instantiated using that payload (this is userful
     * when workin with Events and expansions). Only after both of those fail do we
     * query the API and set the instance variable.
     *
     * 
     * Required config keys:
     *     key: The name of the property to get and set locally.
     *     class: The class name to instantiate.
     *     id: The id of the object to get from Eventbrite. OR
     *     endpoint: The endpoint to call when getting many instances.
     *
     * Optional config keys:
     *     refresh: Whether to force fetching the related object.
     *     options: Optional paramaters to pass to endpoint.
     *
     * Note: Seting `id` and `endpoint` at the same time will result in a 
     * configuration violation.
     * 
     * @param  string  $key     The key name in raw.
     * @param  string  $class   The class path.
     * @param  string  $id      The id of the object to retrieve.
     * @param  boolean $refresh Whether to use the cached object instance or hit the
     *                          API again.
     * @return StdClass         Instance of the desired class.
     */
    private function getRelated(array $config)
    // private function getRelated(string $key, string $class, string $idOrEndpoint, $refresh = false)
    {
        // print('getting: '. $class .'<br>');
        $resource = null;
        $instanceVarName = '_'. $key;
        if ($refresh) {
            unset($this->$instanceVarName);
        }

        if (property_exists($this, $instanceVarName) && !$refresh) {
            // print('prop exists<br>');
            return $this->$instanceVarName;

        } elseif (isset($this->raw[$key])) {
            // print('creating instance<br>');
            $this->$instanceVarName = new $class($this->raw[$key], $this->eventbrite);

        } else {
            // print('making call: ');
            $this->$instanceVarName = $class::find($this->eventbrite, $id);
        }
        return $this->$instanceVarName;   
    }
}