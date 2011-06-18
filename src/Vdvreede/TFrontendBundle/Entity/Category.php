<?php

namespace Vdvreede\TFrontendBundle\Entity;

/**
 * Vdv\AccountBundle\Entity\Category
 *
 * @Table(name="category")
 * @Entity
 */
class Category
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
     * @var text $description
     *
     * @Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $colour
     *
     * @Column(name="colour", type="string", length=45, nullable=true)
     */
    private $colour;

    /**
     * @var integer $type
     *
     * @Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var boolean $reportable
     *
     * @Column(name="reportable", type="boolean", nullable=false)
     */
    private $reportable;

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