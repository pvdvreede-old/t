<?php

namespace Vdvreede\TFrontendBundle\Entity;

/**
 * Vdv\AccountBundle\Entity\Report
 *
 * @Table(name="report")
 * @Entity
 */
class Report
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
     * @var string $sql
     *
     * @Column(name="sql", type="string", length=255, nullable=false)
     */
    private $sql;

    /**
     * @var string $columns
     *
     * @Column(name="columns", type="string", length=255, nullable=true)
     */
    private $columns;

    /**
     * @var boolean $graph
     *
     * @Column(name="graph", type="boolean", nullable=true)
     */
    private $graph;

    /**
     * @var string $graphX
     *
     * @Column(name="graph_x", type="string", length=45, nullable=true)
     */
    private $graphX;

    /**
     * @var string $graphY
     *
     * @Column(name="graph_y", type="string", length=45, nullable=true)
     */
    private $graphY;


}