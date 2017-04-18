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
 * @ORM\Table(name="nurl")
 */
class Nurl
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="nurls")
     * @ORM\JoinColumn(name="`user`", referencedColumnName="id")
     */
    private $user = null;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="nurls")
     * @ORM\JoinTable(name="nurl_tags")
     */
    private $tags;

    /**
     * @ORM\Column(type="date")
     */
    private $crate;

    /**
     * @ORM\Column(type="date")
     */
    private $edit;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accepted = false;

    /**
     * @ORM\ManyToMany(targetEntity="Collection", mappedBy="nurls")
     */
    private $collections;

    public function __construct()
    {
        $this->crate = new \DateTime();
        $this->edit = new \DateTime();
        $this->tags = new ArrayCollection();
        $this->collections = new ArrayCollection();
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
     * @return Nurl
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
     * Set summary
     *
     * @param string $summary
     *
     * @return Nurl
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Nurl
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set crate
     *
     * @param \DateTime $crate
     *
     * @return Nurl
     */
    public function setCrate($crate)
    {
        $this->crate = $crate;

        return $this;
    }

    /**
     * Get crate
     *
     * @return \DateTime
     */
    public function getCrate()
    {
        return $this->crate;
    }

    /**
     * Set edit
     *
     * @param \DateTime $edit
     *
     * @return Nurl
     */
    public function setEdit($edit)
    {
        $this->edit = $edit;

        return $this;
    }

    /**
     * Get edit
     *
     * @return \DateTime
     */
    public function getEdit()
    {
        return $this->edit;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Nurl
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Nurl
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
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Nurl
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add collection
     *
     * @param \AppBundle\Entity\Collection $collection
     *
     * @return Nurl
     */
    public function addCollection(\AppBundle\Entity\Collection $collection)
    {
        $this->collections[] = $collection;

        return $this;
    }

    /**
     * Remove collection
     *
     * @param \AppBundle\Entity\Collection $collection
     */
    public function removeCollection(\AppBundle\Entity\Collection $collection)
    {
        $this->collections->removeElement($collection);
    }

    /**
     * Get collections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollections()
    {
        return $this->collections;
    }
}
