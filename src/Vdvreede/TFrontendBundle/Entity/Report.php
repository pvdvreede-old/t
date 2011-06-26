<?php

namespace Vdvreede\TFrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vdv\AccountBundle\Entity\Report
 *
 * @ORM\Table(name="report")
 * @ORM\Entity
 * @Gedmo\Loggable
 */
class Report
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $sql
     *
     * @ORM\Column(name="sql_statement", type="string", length=255, nullable=false)
     */
    private $sql;

    /**
     * @var string $columns
     *
     * @ORM\Column(name="column_name", type="string", length=255, nullable=true)
     */
    private $columns;

    /**
     * @var boolean $graph
     *
     * @ORM\Column(name="graph", type="boolean", nullable=true)
     */
    private $graph;

    /**
     * @var string $graphX
     *
     * @ORM\Column(name="graph_x", type="string", length=45, nullable=true)
     */
    private $graphX;

    /**
     * @var string $graphY
     *
     * @ORM\Column(name="graph_y", type="string", length=45, nullable=true)
     */
    private $graphY;
    
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
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sql
     *
     * @param string $sql
     */
    public function setSql($sql)
    {
        $this->sql = $sql;
    }

    /**
     * Get sql
     *
     * @return string $sql
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * Set columns
     *
     * @param string $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    /**
     * Get columns
     *
     * @return string $columns
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set graph
     *
     * @param boolean $graph
     */
    public function setGraph($graph)
    {
        $this->graph = $graph;
    }

    /**
     * Get graph
     *
     * @return boolean $graph
     */
    public function getGraph()
    {
        return $this->graph;
    }

    /**
     * Set graphX
     *
     * @param string $graphX
     */
    public function setGraphX($graphX)
    {
        $this->graphX = $graphX;
    }

    /**
     * Get graphX
     *
     * @return string $graphX
     */
    public function getGraphX()
    {
        return $this->graphX;
    }

    /**
     * Set graphY
     *
     * @param string $graphY
     */
    public function setGraphY($graphY)
    {
        $this->graphY = $graphY;
    }

    /**
     * Get graphY
     *
     * @return string $graphY
     */
    public function getGraphY()
    {
        return $this->graphY;
    }
}