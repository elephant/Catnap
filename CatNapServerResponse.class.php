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
abstract class CatNapServerResponse implements CatNapServerInterface {

    protected $_statusCodes = array(200 => 'OK',
                                    201 => 'Created',
                                    202 => 'Accepted',
                                    203 => 'Non-Authoritative Information',
                                    204 => 'No Content',
                                    205 => 'Reset Content',
                                    206 => 'Partial Content',
                                    300 => 'Multiple Choices',
                                    301 => 'Moved Permanently',
                                    302 => 'Found',
                                    303 => 'See Other',
                                    304 => 'Not Modified',
                                    305 => 'Use Proxy',
                                    307 => 'Temporary Redirect',
                                    400 => 'Bad Request',
                                    401 => 'Unauthorized',
                                    402 => 'Payment Required',
                                    403 => 'Forbidden',
                                    404 => 'Not Found',
                                    405 => 'Method Not Allowed',
                                    406 => 'Not Acceptable',
                                    407 => 'Proxy Authentication Required',
                                    408 => 'Request Timeout',
                                    409 => 'Conflict',
                                    410 => 'Gone', #bye bye
                                    411 => 'Length Required',
                                    412 => 'Precondition Failed',
                                    413 => 'Request Entity Too Large',
                                    414 => 'Request-URI Too Long',
                                    415 => 'Unsupported Media Type',
                                    416 => 'Requested Range Not Satisfiable',
                                    417 => 'Expectation Failed',
                                    500 => 'Internal Server Error',
                                    501 => 'Not Implemented',
                                    502 => 'Bad Gateway',
                                    503 => 'Service Unavailable',
                                    504 => 'Gateway Timeout',
                                    505 => 'HTTP Version Not Supported'
                                    );

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
     * @var Exception
     */
    protected $_exception;

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

    /**
     * @var object
     */
    protected $_payload;

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
            case 'exception':
                $this->_exception = $val;
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

    protected function _payload() {
        $this->_payload->data = $this->_data;
        $this->_payload->meta->executionTime = $this->_executionTime;
        if(isset($this->_exception) && $this->_exception instanceof Exception) {
            $this->_payload->error->code = $this->_exception->getCode();
            $this->_payload->error->message = $this->_exception->getMessage();
        }
        return $this->_payload();
    }

}
?>