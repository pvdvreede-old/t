<?php

namespace Vdvreede\TFrontendBundle\Entity;

/**
 * Vdv\AccountBundle\Entity\Transaction
 *
 * @Table(name="transaction")
 * @Entity
 */
class Transaction
{
    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var integer $categoryId
     *
     * @Column(name="category_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $categoryId;

    /**
     * @var integer $userId
     *
     * @Column(name="user_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $userId;

    /**
     * @var integer $accountId
     *
     * @Column(name="account_id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="NONE")
     */
    private $accountId;

    /**
     * @var string $description
     *
     * @Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var text $memo
     *
     * @Column(name="memo", type="text", nullable=true)
     */
    private $memo;

    /**
     * @var date $date
     *
     * @Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var decimal $amount
     *
     * @Column(name="amount", type="decimal", nullable=false)
     */
    private $amount;

    /**
     * @var datetime $lastmodified
     *
     * @Column(name="lastmodified", type="datetime", nullable=true)
     */
    private $lastmodified;

    /**
     * @var datetime $created
     *
     * @Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var boolean $split
     *
     * @Column(name="split", type="boolean", nullable=false)
     */
    private $split;

    /**
     * @var boolean $reportable
     *
     * @Column(name="reportable", type="boolean", nullable=false)
     */
    private $reportable;

    /**
     * @var Account
     *
     * @ManyToOne(targetEntity="Account")
     * @JoinColumns({
     *   @JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;

    /**
     * @var Category
     *
     * @ManyToOne(targetEntity="Category")
     * @JoinColumns({
     *   @JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var Transaction
     *
     * @ManyToOne(targetEntity="Transaction")
     * @JoinColumns({
     *   @JoinColumn(name="parent_transaction_id", referencedColumnName="id")
     * })
     */
    private $parentTransaction;

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