<?php
/**
 * GPL
 */
require_once 'CatnapServer.class.php';

/**
 * Hello World Server
 *
 * @author Jonathan Suchland <jonathan@suchland.org>
 *
 */
class HelloWorldServer extends CatNapServer {

    public function __construct() {
        parent::__construct();
    }

    public function getSayHello($name = '') {
        return "Hello World" . (!empty($name) ? " $name" : "");
    }

}
?>