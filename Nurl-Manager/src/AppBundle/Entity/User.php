<?php
/**
 * Created by PhpStorm.
 * User: mateo
 * Date: 18/04/2017
 * Time: 13:31
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $frozen = false;

    /**
     * @return mixed
     */
    public function getFrozen()
    {
        return $this->frozen;
    }

    /**
     * @param mixed $frozen
     */
    public function setFrozen($frozen)
    {
        $this->frozen = $frozen;
    }

    /**
     * @ORM\OneToMany(targetEntity="Nurl", mappedBy="user")
     */
    private $nurls;

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="`user`")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="Collection", mappedBy="`user`")
     */
    private $collections;

    public function __construct()
    {
        parent::__construct();
        $this->nurls = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->collections = new ArrayCollection();
    }

    /**
     * Add nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return User
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

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return User
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
     * @return User
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
