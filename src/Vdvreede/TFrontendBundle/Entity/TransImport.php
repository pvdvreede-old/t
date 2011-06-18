<?php

namespace Vdvreede\TFrontendBundle\Entity;

/**
 * Vdv\AccountBundle\Entity\TransImport
 *
 * @Table(name="trans_import")
 * @Entity
 */
class TransImport
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
     * @var integer $accountId
     *
     * @Column(name="account_id", type="integer", nullable=false)
     */
    private $accountId;

    /**
     * @var integer $descriptionField
     *
     * @Column(name="description_field", type="integer", nullable=false)
     */
    private $descriptionField;

    /**
     * @var integer $memoField
     *
     * @Column(name="memo_field", type="integer", nullable=true)
     */
    private $memoField;

    /**
     * @var integer $dateField
     *
     * @Column(name="date_field", type="integer", nullable=false)
     */
    private $dateField;

    /**
     * @var integer $amountField
     *
     * @Column(name="amount_field", type="integer", nullable=false)
     */
    private $amountField;

    /**
     * @var Account
     *
     * @ManyToOne(targetEntity="Account")
     * @JoinColumns({
     *   @JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;


}