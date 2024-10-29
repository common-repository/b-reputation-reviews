<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace b_reputation;

abstract class singleton {

    /**
     * Constructor of the Base class
     */
    protected function __construct() {

    }

    /**
     * Method used to create the singlton implmentation
     *
     * @static
     *
     * @final
     *
     * @staticvar static $instance For capturing the object of the class
     *
     * @return \static return the class object
     */
    public static function get_instance() {
        static $instance;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }

    /**
     * Method to avoid the php cloning
     *
     * @return null nothing
     */
    private function __clone() {

    }

    /**
     * Method to avoid the wakup
     *
     * @return null Nothing
     */
    private function __wakeup() {

    }

}
