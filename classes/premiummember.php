<?php

/**
 * The PremiumMember class represents a Premium Member of the dating application.
 *
 * Premium members may add indoor and outdoor interests to their dating profile
 * in addition to general information about themselves all Members can input.
 *
 * @author Kianna Dyck
 * @copyright 2018
 *
 */
class PremiumMember extends Member
    {
        // declare attributes
        private $_inDoorInterests;
        private $_outDoorInterests;

    /**
     * This method retrieves and returns an array of a premium member's indoor interests.
     * @return Array
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * This method sets the indoor interests of the premium member to the given array value.
     * @param Array $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * This method retrieves and returns an array of a premium member's outdoor interests.
     * @return Array
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * This method sets the outdoor interests of the premium member to the given array value.
     * @param Array $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }

    }