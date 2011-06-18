<?php

namespace Vdvreede\TFrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vdv\AccountBundle\Entity\Report
 *
 * @ORM\Table(name="report")
 * @ORM\Entity
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


}