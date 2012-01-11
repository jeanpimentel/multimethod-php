<?php
/**
 * LICENSE
 *
 * Copyright (C) 2012 Jean Pimentel <contato@jeanpimentel.com.br>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

function multimethod() {
    return new Multimethod();
}

class Multimethod {

    protected $_dispatch;
    protected $_methods;
    protected $_default;

    public function __construct()
    {
        $this->_dispatch = function($a) { return $a; };
        $this->_methods = array();
        $this->_default = function() {};
    }
    
    public function dispatch($dispatch) {
        if(\is_callable($dispatch))
            $this->_dispatch = $dispatch;
        elseif(\is_string($dispatch))
            $this->_dispatch = function($object) use($dispatch) { return $object->{$dispatch}; };
        else
            throw new \Exception("dispatch requires a function or a string.");

       return $this;
    }

    public function when($match, $function) {
        $this->_methods[(string) $match] = $function;
        return $this;
    }

    public function remove($match) {
        if($this->_methods[(string) $match])
            unset($this->_methods[(string) $match]);
        return $this;
    }

    public function setDefault($default) {
        $this->_default = $default;
        return $this;
    }

    public function create() {
        $dispatch = $this->_dispatch;
        $methods = $this->_methods;
        $default = $this->_default;
        return function($input) use($dispatch, $methods, $default) {
            $input = $dispatch($input);
            if(isset ($methods[(string) $input])) {
                $method = $methods[(string) $input];
                $output = (is_callable($method)) ? $method($input) : $method;
            }
            else
                $output = (is_callable($default)) ? $default($input) : $default;

            echo $output;
        };
    }

}
?>
