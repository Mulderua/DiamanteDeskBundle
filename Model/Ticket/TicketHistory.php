<?php
/*
 * Copyright (c) 2014 Eltrino LLC (http://eltrino.com)
 *
 * Licensed under the Open Software License (OSL 3.0).
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://opensource.org/licenses/osl-3.0.php
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eltrino.com so we can send you a copy immediately.
 */
namespace Diamante\DeskBundle\Model\Ticket;

use Diamante\DeskBundle\Model\Shared\Entity;

class TicketHistory implements Entity
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var integer
     */
    protected $ticketId;

    /**
     * @var string
     */
    protected $ticketKey;

    /**
     * @param integer $ticketId
     * @param string $ticketKey
     */
    public function __construct($ticketId, $ticketKey) {
        $this->ticketId = $ticketId;
        $this->ticketKey = $ticketKey;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * @return string
     */
    public function getTicketKey()
    {
        return $this->ticketKey;
    }
}