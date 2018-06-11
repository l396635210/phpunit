<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/24/18
 * Time: 6:00 AM
 */

namespace App\Tests\Entity;


use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Exception\DinosaurAreRunningRampantException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class EnclosureTest extends TestCase
{

    /**
     * @var Enclosure
     */
    private $enclosure;

    public function setUp()
    {
        $this->enclosure = new Enclosure(true);
    }

    public function testItHasNoDinosaurByDefault(){

        $this->assertEmpty($this->enclosure->getDinosaurs());
    }

    public function testAddDinosaurs(){

        $this->enclosure->addDinosaur(new Dinosaur());
        $this->enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $this->enclosure->getDinosaurs());
    }

    /**
     * @expectedException App\Exception\NotABuffetException
     * @throws App\Exception\NotABuffetException
     */
    public function testItDoesNotAllowCarnivorousDinosToMixHerbivores(){

        $this->enclosure->addDinosaur(new Dinosaur());

        $this->enclosure->addDinosaur(new Dinosaur('Velociraptor', true));

    }

    /**
     * @throws \App\Exception\NotABuffetException
     *
     * @expectedException App\Exception\DinosaurAreRunningRampantException
     * @expectedExceptionMessage Are you craaazy ?!?!
     */
    public function testItNotAllowToAddDinosaurToUnsecureEnclosures(){

        $enclosure = new Enclosure();

        $enclosure->addDinosaur(new Dinosaur());
    }

}