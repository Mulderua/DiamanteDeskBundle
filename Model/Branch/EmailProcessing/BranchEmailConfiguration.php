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
namespace Diamante\DeskBundle\Model\Branch\EmailProcessing;

use Diamante\DeskBundle\Model\Shared\Entity;
use Diamante\DeskBundle\Model\Branch\Branch;

class BranchEmailConfiguration implements Entity
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Branch
     */
    protected $branch;

    /**
     * @var array
     */
    protected $customerDomains;

    /**
     * @var string
     */
    protected $supportAddress;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @param Branch $branch
     * @param $customerDomains
     * @param $supportAddress
     */
    public function __construct(Branch $branch, $customerDomains, $supportAddress)
    {
        $this->branch               = $branch;
        $this->customerDomains      = $customerDomains;
        $this->supportAddress       = $supportAddress;
        $this->createdAt            = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->updatedAt            = clone $this->createdAt;
    }

    /**
     * Update BranchEmailConfiguration
     *
     * @param array $customerDomains
     * @param string $supportAddress
     */
    public function update($customerDomains, $supportAddress)
    {
        $this->customerDomains      = $customerDomains;
        $this->supportAddress       = $supportAddress;
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Branch
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @return array
     */
    public function getCustomerDomains()
    {
        return $this->customerDomains;
    }

    /**
     * @return array
     */
    public function getCustomerDomainsAsArray()
    {
        if (empty($this->customerDomains)) {
            return array();
        }
        $delimiter = ',';
        if (trim($this->customerDomains)) {
            $separator = trim($delimiter);
        } else {
            $separator = $delimiter;
        }
        $arrayValue = explode($separator, $this->customerDomains);
        return $arrayValue;
    }

    /**
     * @return string
     */
    public function getSupportAddress()
    {
        return $this->supportAddress;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
