<?php

namespace Vdvreede\TFrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vdv\AccountBundle\Entity\Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="Vdvreede\TFrontendBundle\Repository\TransactionRepository")
 */
class Transaction
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
     * @var integer $categoryId
     *
     * @ORM\Column(name="category_id", type="integer", nullable=true)
     */
    private $categoryId;

    /**
     * @var integer $userId
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var integer $accountId
     *
     * @ORM\Column(name="account_id", type="integer", nullable=false)
     */
    private $accountId;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var text $memo
     *
     * @ORM\Column(name="memo", type="text", nullable=true)
     */
    private $memo;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var decimal $amount
     *
     * @ORM\Column(name="amount", type="decimal", nullable=false)
     */
    private $amount;

    /**
     * @var boolean $split
     *
     * @ORM\Column(name="split", type="boolean", nullable=false)
     */
    private $split;

    /**
     * @var boolean $reportable
     *
     * @ORM\Column(name="reportable", type="boolean", nullable=false)
     */
    private $reportable;

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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var Transaction
     *
     * @ORM\ManyToOne(targetEntity="Transaction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_transaction_id", referencedColumnName="id")
     * })
     */
    private $parentTransaction;

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
     * Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set categoryId
     *
     * @param integer $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * Get categoryId
     *
     * @return integer $categoryId
     */
    public function getCategoryId()
    {
        return $this->categoryId;
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
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set memo
     *
     * @param text $memo
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;
    }

    /**
     * Get memo
     *
     * @return text $memo
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amount
     *
     * @param decimal $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @return decimal $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set lastmodified
     *
     * @param datetime $lastmodified
     */
    public function setLastmodified($lastmodified)
    {
        $this->lastmodified = $lastmodified;
    }

    /**
     * Get lastmodified
     *
     * @return datetime $lastmodified
     */
    public function getLastmodified()
    {
        return $this->lastmodified;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime $created
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set split
     *
     * @param boolean $split
     */
    public function setSplit($split)
    {
        $this->split = $split;
    }

    /**
     * Get split
     *
     * @return boolean $split
     */
    public function getSplit()
    {
        return $this->split;
    }

    /**
     * Set reportable
     *
     * @param boolean $reportable
     */
    public function setReportable($reportable)
    {
        $this->reportable = $reportable;
    }

    /**
     * Get reportable
     *
     * @return boolean $reportable
     */
    public function getReportable()
    {
        return $this->reportable;
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
     * Set category
     *
     * @param Vdvreede\TFrontendBundle\Entity\Category $category
     */
    public function setCategory(\Vdvreede\TFrontendBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Vdvreede\TFrontendBundle\Entity\Category $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set parentTransaction
     *
     * @param Vdvreede\TFrontendBundle\Entity\Transaction $parentTransaction
     */
    public function setParentTransaction(\Vdvreede\TFrontendBundle\Entity\Transaction $parentTransaction)
    {
        $this->parentTransaction = $parentTransaction;
    }

    /**
     * Get parentTransaction
     *
     * @return Vdvreede\TFrontendBundle\Entity\Transaction $parentTransaction
     */
    public function getParentTransaction()
    {
        return $this->parentTransaction;
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