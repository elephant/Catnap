<?php
/**
 * GPL
 */

/**
 * Represents a server response
 *
 * @author Jonathan Suchland <jonathan@suchland.org>
 *
 * @property-read float $requestTime
 * @property-read float $responseTime
 * @property-read float $executionTime
 * @property-read int   $statusCode
 * @property-write mixed $data
 */
abstract class CatNapServerResponse {

    /**
     * @var float
     */
    protected $_requestTimestamp;

    /**
     * @var float
     */
    protected $_responseTimestamp;

    /**
     * @var float
     */
    protected $_executionTime;

    /**
     * @var mixed
     */
    protected $_data;

    /**
     * @var int
     */
    protected $_statusCode;

    /**
     * @var string
     */
    protected $_stackTrace;

    /**
     * @var array
     */
    protected $_httpHeaders;

    public function __construct() {
        $this->_strictlyREST = true;
        $this->_introspect();
        $this->_httpHeaders = array();
    }

    public function __get($var) {
        switch($var) {
            case 'requestTime':
                $val = $this->_requestTime;
                break;
            case 'responseTime':
                $val = $this->_responseTime;
                break;
            case 'executionTime':
                $val = $this->_executionTime;
                break;
            case 'statusCode':
                $val = $this->_statusCode;
                break;
            case 'data':
                $val = $this->_data;
                break;
            default:
                $val = null;
                break;
        }

        return $val;
    }

    public function __set($var, $val) {
        switch($var) {
            case 'data':
                $this->_data = $val;
                break;
        }
    }

    /**
     * Set the HTTP Headers
     * @todo this is only a stub
     *
     * @return void
     */
    public function setHttpHeaders() {
        //@todo put common headers here
    }

}
?>