<?php
/**
 * @author Jonathan Suchland <jonathan@suchland.org>
 */
require_once '../CatnapServer.class.php';
require_once 'HelloWorldServer.class.php';

$helloWorldServer = new HelloWorldServer();
$helloWorldServer->serve();
?>