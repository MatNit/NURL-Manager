<?php
/**
 * Created by PhpStorm.
 * User: mateo
 * Date: 18/04/2017
 * Time: 16:57
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="report")
 */
class Report
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $email = null;

    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Nurl", inversedBy="reports")
     * @ORM\JoinColumn(name="nurl", referencedColumnName="id")
     */
    private $nurl;

    public function __construct()
    {
        $this->date = new \DateTime();
    }


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
     * Set nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return Report
     */
    public function setNurl(\AppBundle\Entity\Nurl $nurl = null)
    {
        $this->nurl = $nurl;

        return $this;
    }

    /**
     * Get nurl
     *
     * @return \AppBundle\Entity\Nurl
     */
    public function getNurl()
    {
        return $this->nurl;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Report
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Report
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
