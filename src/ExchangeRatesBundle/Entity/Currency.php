<?php

namespace ExchangeRatesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Currency
 *
 * @ORM\Table(name="currency")
 * @ORM\Entity(repositoryClass="ExchangeRatesBundle\Repository\CurrencyRepository")
 */
class Currency
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var float
     *
     * @ORM\Column(name="usd", type="float")
     */
    private $usd;

    /**
     * @var float
     *
     * @ORM\Column(name="eur", type="float")
     */
    private $eur;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_at", type="integer", length=11)
     */
    private $created_at;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param int $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return float
     */
    public function getUsd()
    {
        return $this->usd;
    }

    /**
     * @param float $usd
     */
    public function setUsd($usd)
    {
        $this->usd = $usd;
    }

    /**
     * @return float
     */
    public function getEur()
    {
        return $this->eur;
    }

    /**
     * @param float $eur
     */
    public function setEur($eur)
    {
        $this->eur = $eur;
    }

}
