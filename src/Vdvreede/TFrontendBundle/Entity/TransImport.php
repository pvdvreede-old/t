<?php

namespace Vdvreede\TFrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vdv\AccountBundle\Entity\TransImport
 *
 * @ORM\Table(name="trans_import", uniqueConstraints={@ORM\UniqueConstraint(name="trans_import_row", columns={"name", "user_id"})})
 * @ORM\Entity(repositoryClass="Vdvreede\TFrontendBundle\Repository\TransImportRepository")
 * @Gedmo\Loggable
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string $hasHeader
     *
     * @ORM\Column(name="has_header", type="boolean", length=50, nullable=true)
     */
    private $hasHeader;

    /**
     * @var integer $accountId
     *
     * @ORM\Column(name="account_id", type="integer", nullable=false)
     */
    private $accountId;

    /**
     * @var integer $userId
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

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
     * @var integer $creditField
     *
     * @ORM\Column(name="credit_field", type="integer", nullable=true)
     */
    private $creditField;
    
    /**
     * @var integer $debitField
     *
     * @ORM\Column(name="debit_field", type="integer", nullable=true)
     */
    private $debitField;
    
     /**
     * @var integer $dateFormat
     *
     * @ORM\Column(name="date_format", type="string", length=255, nullable=false)
     */
    private $dateFormat;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;
    
     /**
     * @var datetime $created
     * 
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;
     
    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * Get to string
     *
     * @return integer $id
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set accountId
     *
     * @param integer $accountId
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * Get accountId
     *
     * @return integer $accountId
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set accountId
     *
     * @param integer $accountId
     */
    public function setHasHeader($hasHeader)
    {
        $this->hasHeader = $hasHeader;
    }

    /**
     * Get accountId
     *
     * @return integer $accountId
     */
    public function getHasHeader()
    {
        return $this->hasHeader;
    }
    
    /**
     * Set accountId
     *
     * @param integer $accountId
     */
    public function setDateFormat($hasHeader)
    {
        $this->dateFormat = $hasHeader;
    }

    /**
     * Get accountId
     *
     * @return integer $accountId
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * Set descriptionField
     *
     * @param integer $descriptionField
     */
    public function setDescriptionField($descriptionField)
    {
        $this->descriptionField = $descriptionField;
    }

    /**
     * Get descriptionField
     *
     * @return integer $descriptionField
     */
    public function getDescriptionField()
    {
        return $this->descriptionField;
    }

    /**
     * Set memoField
     *
     * @param integer $memoField
     */
    public function setMemoField($memoField)
    {
        $this->memoField = $memoField;
    }

    /**
     * Get memoField
     *
     * @return integer $memoField
     */
    public function getMemoField()
    {
        return $this->memoField;
    }

    /**
     * Set dateField
     *
     * @param integer $dateField
     */
    public function setDateField($dateField)
    {
        $this->dateField = $dateField;
    }

    /**
     * Get dateField
     *
     * @return integer $dateField
     */
    public function getDateField()
    {
        return $this->dateField;
    }

    /**
     * Set amountField
     *
     * @param integer $amountField
     */
    public function setAmountField($amountField)
    {
        $this->amountField = $amountField;
    }

    /**
     * Get amountField
     *
     * @return integer $amountField
     */
    public function getAmountField()
    {
        return $this->amountField;
    }
    
    /**
     * Set amountField
     *
     * @param integer $amountField
     */
    public function setCreditField($creditField)
    {
        $this->creditField = $creditField;
    }

    /**
     * Get amountField
     *
     * @return integer $amountField
     */
    public function getCreditField()
    {
        return $this->creditField;
    }
    
    /**
     * Set amountField
     *
     * @param integer $amountField
     */
    public function setDebitField($debitField)
    {
        $this->debitField = $debitField;
    }

    /**
     * Get amountField
     *
     * @return integer $amountField
     */
    public function getDebitField()
    {
        return $this->debitField;
    }

    /**
     * Set account
     *
     * @param Vdvreede\TFrontendBundle\Entity\Account $account
     */
    public function setAccount(\Vdvreede\TFrontendBundle\Entity\Account $account)
    {
        $this->account = $account;
    }

    /**
     * Get account
     *
     * @return Vdvreede\TFrontendBundle\Entity\Account $account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get userId
     *
     * @return integer $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set user
     *
     * @param Vdvreede\TFrontendBundle\Entity\User $user
     */
    public function setUser(\Vdvreede\TFrontendBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Vdvreede\TFrontendBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }
}