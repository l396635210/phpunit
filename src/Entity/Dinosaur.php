<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DinosaurRepository")
 * @ORM\Entity
 * @ORM\Table(name="dinosaur")
 */
class Dinosaur
{

    const LARGE = 10;

    const HUGE = 20;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $length = 0;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $genus;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $isCarnivorous;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Enclosure", inversedBy="dinosaurs", cascade={"persist"})
     * @var Enclosure
     */
    private $enclosure;

    public function __construct(string $genus = 'Unknown', bool $isCarnivorous = false)
    {
        $this->genus = $genus;
        $this->isCarnivorous = $isCarnivorous;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getSpecification(): string
    {
        return sprintf(
            'The %s %scarnivorous dinosaur is %d meters long',
            $this->genus,
            $this->isCarnivorous ? '' : 'non-',
            $this->length
        );
    }

    public function getGenus()
    {
        return $this->genus;
    }

    public function isCarnivorous()
    {
        return $this->isCarnivorous;
    }

    public function setEnclosure(Enclosure $enclosure): self
    {
        $this->enclosure = $enclosure;
        return $this;
    }
}
