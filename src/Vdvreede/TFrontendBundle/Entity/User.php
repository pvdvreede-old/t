<?php

namespace Vdvreede\TFrontendBundle\Entity;

/**
 * Vdv\AccountBundle\Entity\User
 *
 * @Table(name="user")
 * @Entity
 */
class User
{
    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $email
     *
     * @Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string $openId
     *
     * @Column(name="open_id", type="string", length=255, nullable=false)
     */
    private $openId;


}