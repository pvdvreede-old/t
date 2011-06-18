<?php

namespace Vdvreede\TFrontendBundle\Entity;

/**
 * Vdv\AccountBundle\Entity\Account
 *
 * @Table(name="account")
 * @Entity
 */
class Account
{
    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $userId
     *
     * @Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string $name
     *
     * @Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string $description
     *
     * @Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * @var integer $type
     *
     * @Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User")
     * @JoinColumns({
     *   @JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}