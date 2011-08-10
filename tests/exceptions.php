<?php
require_once 'PHPUnit.php';
require_once 'examples/HelloWorldServer.class.php';

class ExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException           Exception
     * @expectedExceptionMessage    Message
     * @expectedExceptionCode       20
     */
    public function testMethodNotAllowed() {
        $_REQUEST['CatNapServerMethod'] = 'getSayHello';
        $helloWorldServer = new HelloWorldServer();
        $helloWorldServer->serve();
        //Exception('Method Not Allowed. The request should be "' . $this->_methodRequiredRequestMethod . '".', 405)
    }

    /**
     * @expectedException           Exception
     * @expectedExceptionMessage    Message
     * @expectedExceptionCode       20
     */
    public function testBadRequestMissingMethodName() {
        $helloWorldServer = new HelloWorldServer();
        $helloWorldServer->serve();
        //'Bad Request. The request did not contain a "CatNapServerMethod" argument.', 400
    }

    /**
     * @expectedException           Exception
     * @expectedExceptionMessage    Message
     * @expectedExceptionCode       20
     */
    public function testNotFoundMissingMethodName() {
        $helloWorldServer = new HelloWorldServer();
        $helloWorldServer->serve();
        //'Not Found', 404
    }
}
?>