<?php
/**
 * GPL
 */

/**
 * Represents an exception server response
 *
 * @author Jonathan Suchland <jonathan@suchland.org>
 *
 * @property-read float $requestTime
 * @property-read float $responseTime
 * @property-read float $executionTime
 * @property-read int   $statusCode
 * @property-write mixed $data
 */
class CatNapServerExceptionResponse extends CatNapServerResponse {

    public $code;
    public $message;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Set the HTTP Headers
     *
     * @return void
     */
    public function setHttpHeaders() {
        $this->_httpHeaders[] = "Content-Type: text/plain";
        parent::setHttpHeaders();
    }

    public function encode() {
        return $this->code . ' ' . $this->message;
    }
}
?>