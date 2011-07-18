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
 * @property-write int   $statusCode
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
        $this->_requestTimestamp = microtime(true);
        $this->_responseTimestamp = 0;
        $this->_statusCode = 200;
    }

    public function __get($var) {
        switch($var) {
            case 'requestTimestamp':
                $val = $this->_requestTimestamp;
                break;
            case 'responseTimestamp':
                $val = $this->_responseTimestamp;
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
            case 'statusCode':
                if(is_int($val) && $val >= 600) {
                    $this->_statusCode = $val;
                }
                break;
            case 'requestTimestamp':
                $this->_requestTimestamp = $val;
                $this->_calculateExecutionTime();
                break;
            case 'responseTimestamp':
                $this->_responseTimestamp = $val;
                $this->_calculateExecutionTime();
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

    /**
     * Add a custom status code.
     * Codes < 600 are reserved for HTTP status codes
     *
     * @return void
     */
    protected function _addStatusCode($code, $message) {
        if(is_int($code) && $code >= 600
                         && !array_key_exists($code, $this->_statusCodes)
                         && !empty($message)) {
            $this->_statusCodes[$code] = $message;
        }
    }

    /**
     * Generates the full response payload that will be returned to the client.
     *
     * @return object
     */
    protected function _payload() {
        if(!isset($this->_payload)) {
            $this->_payload->data = $this->_data;
            if($this->_responseTimestamp < 1) {
                $this->responseTimestamp = microtime(true);
            }
            $this->_payload->meta->executionTime = $this->_executionTime;
            $this->_payload->meta->status->code = $this->_statusCode;
            if(array_key_exists($this->_statusCode, $this->_statusCodes)) {
                $this->_payload->meta->status->message = $this->_statusCodes[$this->_statusCode];
            }
            if(isset($this->_exception) && $this->_exception instanceof Exception) {
                $this->_payload->error->code = $this->_payload->meta->status->code = $this->_exception->getCode();
                $this->_payload->error->message = $this->_exception->getMessage();
            }
        }
        return $this->_payload();
    }

    /**
     * Calculate the execution time of the web service call.
     *
     * @return void
     */
    private function _calculateExecutionTime() {
        if($this->_requestTimestamp > 0 && $this->_responseTimestamp > 0) {
            $this->_executionTime = $this->_responseTimestamp - $this->_requestTimestamp;
        } else {
            $this->_executionTime = null;
        }
    }

}
?>