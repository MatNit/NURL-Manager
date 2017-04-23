<?php
/**
 * Created by PhpStorm.
 * User: mateo
 * Date: 18/04/2017
 * Time: 14:20
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="nurls")
     * @ORM\JoinColumn(name="`user`", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accepted = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $votes = 0;

    /**
     * @ORM\ManyToMany(targetEntity="Nurl", mappedBy="tags")
     */
    private $nurls;

    public function __construct()
    {
        $this->nurls = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Tag
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Tag
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set votes
     *
     * @param integer $votes
     *
     * @return Tag
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * Get votes
     *
     * @return integer
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Tag
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return Tag
     */
    public function addNurl(\AppBundle\Entity\Nurl $nurl)
    {
        $this->nurls[] = $nurl;

        return $this;
    }

    /**
     * Remove nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     */
    public function removeNurl(\AppBundle\Entity\Nurl $nurl)
    {
        $this->nurls->removeElement($nurl);
    }

    /**
     * Get nurls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNurls()
    {
        return $this->nurls;
    }
}
