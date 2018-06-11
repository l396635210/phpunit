<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/24/18
 * Time: 6:03 AM
 */

namespace App\Entity;


use App\Exception\DinosaurAreRunningRampantException;
use App\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure
{

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ArrayCollection | Security[]
     * @ORM\OneToMany(targetEntity="App\Entity\Security", mappedBy="enclosure", cascade={"persist"})
     */
    private $securities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"})
     * @var ArrayCollection | Dinosaur[]
     */
    private $dinosaurs;

    public function __construct(bool $withBasicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($withBasicSecurity){
            $this->securities[] = new Security('Fence', true, $this);
        }
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection|Dinosaur[]
     */
    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    public function getDinosaurCount(): int
    {
        return $this->dinosaurs->count();
    }

    /**
     * @param Dinosaur $dinosaur
     * @return Enclosure
     * @throws NotABuffetException
     */
    public function addDinosaur(Dinosaur $dinosaur): self
    {

        if (!$this->isSecurityActive()){
            throw new DinosaurAreRunningRampantException('Are you craaazy ?!?!');
        }

        if (!$this->canAddDinosaur($dinosaur)){
            throw new NotABuffetException();
        }
        $this->dinosaurs[] = $dinosaur;
        return $this;
    }

    private function canAddDinosaur(Dinosaur $dinosaur):bool
    {
        return count($this->dinosaurs) === 0
            || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
    }

    public function isSecurityActive() : bool
    {
        foreach ($this->securities as $security){
            if ($security->isActive()){
                return true;
            }
        }

        return false;
    }

    public function addSecurity(Security $security): self
    {
        $this->securities[] = $security;
        return $this;
    }

    /**
     * @return ArrayCollection|Security[]
     */
    public function getSecurities(): Collection
    {
        return $this->securities;
    }

}