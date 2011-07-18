<?php
/**
 * GPL
 */

/**
 * @todo this will overwrite any previously declared __autoload function. need to fix that.
 */
function __autoload($className) {
    require_once $className . '.class.php';
}

/**
 * @author Jonathan Suchland <jonathan@suchland.org>
 *
 * @property-read bool $debug
 * @property-read string $responseFormat
 */
abstract class CatNapServer {

    /**
     * @var bool
     */
    protected $_strictlyREST;

    /**
     * @var string
     */
    protected $_methodName;

    /**
     * @var array
     */
    protected $_methodArgs;

    /**
     * @var string
     */
    protected $_responseFormat;

    /**
     * @var Exception
     */
    protected $_exception;

    /**
     * @var bool
     */
    protected $_debug;

    public function __construct() {
        set_exception_handler(array($this, '_exceptionHandler'));
        $this->_strictlyREST = true;
        $this->_methodArgs = array();
        $this->_introspect();
    }

    public function __get($var) {
        switch($var) {
            case 'debug':
                $val = $this->_requestTime;
                break;
            case 'responseFormat':
                $val = $this->_responseFormat;
                break;
            default:
                $val = null;
                break;
        }

        return $val;
    }

    /**
     * Toggle the REST adherence.
     * If true (default), then the server will enforce GET, POST, PUT, DEL, HEAD rules on method calls.
     * If false, then anything goes (you can call a post method via get, etc.).
     *
     * @param bool $strictlyREST
     * @return void
     */
    public function beStrictlyREST($strictlyREST = true) {
        $this->_strictlyREST = $strictlyREST;
    }

    /**
     * Return the state of whether this server is strictly adhering to REST.
     * If true (default), then the server will enforce GET, POST, PUT, DEL, HEAD rules on method calls.
     * If false, then anything goes (you can call a post method via get, etc.).
     *
     * @return bool
     */
    public function isStrictlyREST() {
        return $this->_strictlyREST;
    }

    /**
     * Serve the request.
     *
     * @return mixed
     */
    public function serve() {
        $this->_validateRequest();
        $responseObj = $this->_createResponseObj();
        $responseObj->data = $this->_callMethod($this->_methodName, $this->_methodArgs);
        if(isset($_SERVER)) {
            //someone called this method natively
            return $responseObj;
        } else {
            print $responseObj->encode();
        }
    }

    /**
     * Determines the available methods of this class to expose as web services
     * @todo this is only a stub
     *
     * @return void
     */
    protected function _introspect() {
        //1. determine method
        //2. determine response type
        //3. determine args/map to method
    }

    /**
     * Validate the request
     * - check required method arguments and RESTful request (if strictlyRest)
     * - throws an Exception if request is invalid
     * @todo this is only a stub
     *
     * @return void
     */
    protected function _validateRequest() {
        //1. request args
        //2. request method (if strictlyRest)
    }

    /**
     * Wraps the call to the method.
     * @todo this is only a stub
     *
     * @return string The response format will be the same as the request format (json, yaml, phps, wddx-xml)
     */
    protected function _callMethod($method, $args = null) {
        if(!method_exists($this, $this->_methodName)) {
            throw new Exception(404, 'Not Found');
        }
        $this->$method($args);
    }

    /**
     * Converts a raw response to a CatnapServerResponse object
     *
     * @return CatnapServerResponse of appropriate type
     */
    private function _createResponseObj() {
        switch($this->_responseFormat) {
            case 'json':
                $responseObj = new CatnapServerJSONResponse();
                break;
            case 'wddx':
            case 'xml':
                $responseObj = new CatnapServerWDDXResponse();
                break;
            case 'yaml':
                $responseObj = new CatnapServerYAMLResponse();
                break;
            default:
                $responseObj = new CatnapServerTextResponse();
        }
        return $responseObj;
    }

    private function _exceptionHandler($exception) {
        if(isset($_SERVER)) {
            //someone called this method natively
            restore_exception_handler();
            throw $exception;
        } else {
            $responseObj = $this->_createResponseObj();
            $responseObj->exception = $exception;
            print $responseObj->encode();
        }
    }

}
?>