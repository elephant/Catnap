<?php
/**
 * GPL
 */

/**
 * @author Jonathan Suchland <jonathan@suchland.org>
 *
 * @property-read bool $debug
 * @property-read string $responseFormat
 */
class CatNapServer {

    /**
     * @var bool
     */
    protected $_strictlyREST;

    /**
     * @var string
     */
    protected $_responseFormat;

    /**
     * @var bool
     */
    protected $_debug;

    public function __construct() {
        $this->_strictlyREST = true;
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
        $httpResponse = isset($_SERVER) ? true : false;
        $response = _callMethod("hello", "");
        if($httpResponse) {
            return $response;
        } else {
            json_encode($response);
        }
    }

    /**
     * Determines the available methods of this class to expose as web services
     *
     * @return void
     */
    protected function _introspect() {

    }

    /**
     * Wraps the call to the method.
     *
     * @return string The response format will be the same as the request format (json, yaml, phps, wddx-xml)
     */
    protected function _callMethod($method, $args = null) {
        return array(1,2,3);
    }

}
?>