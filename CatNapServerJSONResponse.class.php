<?php
/**
 * GPL
 */

/**
 * Represents a JSON server response
 *
 * @author Jonathan Suchland <jonathan@suchland.org>
 *
 * @property-read float $requestTime
 * @property-read float $responseTime
 * @property-read float $executionTime
 * @property-read int   $statusCode
 * @property-write mixed $data
 */
class CatNapServerJSONResponse extends CatNapServerResponse {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Set the HTTP Headers
     *
     * @return void
     */
    public function setHttpHeaders() {
        $this->_httpHeaders[] = "Content-Type: application/json";
        parent::setHttpHeaders();
    }

}
?>