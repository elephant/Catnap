<?php
/**
 * GPL
 */

/**
 * Hello World Server
 *
 * @author Jonathan Suchland <jonathan@suchland.org>
 *
 */
class HelloWorldServer extends CatNapServer {

    public function __construct() {
        $this->_strictlyREST = true;
        $this->_introspect();
    }

    public function getSayHello($name = '') {

        return "Hello World" . (!empty($name) ? " $name" : "");
    }

}
?>