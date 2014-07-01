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
namespace Eltrino\DiamanteDeskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass="Eltrino\DiamanteDeskBundle\Ticket\Infrastructure\Persistence\Doctrine\DoctrineCommentRepository")
 * @ORM\Table(name="diamante_comment")
 *
 */
class Comment extends \Eltrino\DiamanteDeskBundle\Ticket\Model\Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Comment content
     *
     * @var string $text
     *
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @var Ticket
     *
     * @ORM\ManyToOne(targetEntity="Ticket", inversedBy="comments")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $ticket;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="author", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $author;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Attachment")
     * @ORM\JoinTable(name="diamante_comment_attachments",
     *      joinColumns={@ORM\JoinColumn(name="comment_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="attachment_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $attachments;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    public static function getClassName()
    {
        return __CLASS__;
    }
}
