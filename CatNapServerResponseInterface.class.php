<?php
/**
 * GPL
 */

/**
 * Represents a server response
 *
 * @author Jonathan Suchland <jonathan@suchland.org>
 */
interface CatNapServerResponseInterface {

    public function encode();

    public function setHttpHeaders();

}
?>