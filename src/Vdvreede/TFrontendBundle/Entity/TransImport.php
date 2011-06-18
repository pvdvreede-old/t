<?php

namespace Vdvreede\TFrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vdv\AccountBundle\Entity\TransImport
 *
 * @ORM\Table(name="trans_import")
 * @ORM\Entity
 */
class TransImport
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;    

    /**
     * @var integer $accountId
     *
     * @ORM\Column(name="account_id", type="integer", nullable=false)
     */
    private $accountId;

    /**
     * @var integer $descriptionField
     *
     * @ORM\Column(name="description_field", type="integer", nullable=false)
     */
    private $descriptionField;

    /**
     * @var integer $memoField
     *
     * @ORM\Column(name="memo_field", type="integer", nullable=true)
     */
    private $memoField;

    /**
     * @var integer $dateField
     *
     * @ORM\Column(name="date_field", type="integer", nullable=false)
     */
    private $dateField;

    /**
     * @var integer $amountField
     *
     * @ORM\Column(name="amount_field", type="integer", nullable=false)
     */
    private $amountField;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;


}