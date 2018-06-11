<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/28/18
 * Time: 5:52 AM
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="security")
 */
class Security
{

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @var Enclosure
     * @ORM\ManyToOne(targetEntity="App\Entity\Enclosure", inversedBy="securities")
     */
    private $enclosure;

    public function __construct(string $name, bool $isActive, Enclosure $enclosure)
    {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->enclosure = $enclosure;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

}