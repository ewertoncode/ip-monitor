<?php

namespace IPMonitor\MonitorBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * Ips
 *
 * @ORM\Table(name="ips")
 * @ORM\Entity()
 */
class IP
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
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=200)
     */
    private $ip;

    /**
     * @var boolean
     *
     * @ORM\Column(name="referencia", type="boolean", nullable=true)
     */
    private $referencia;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return IP
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return IP
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isReferencia()
    {
        return $this->referencia;
    }

    /**
     * @param boolean $referencia
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;
    }



}

