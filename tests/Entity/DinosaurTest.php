<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/22/18
 * Time: 6:26 AM
 */

namespace App\Tests\Entity;


use App\Entity\Dinosaur;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DinosaurTest extends TestCase
{

    public function testSettingLength(){
        $dinosaur = new Dinosaur();
        $this->assertSame(0, $dinosaur->getLength());

        $dinosaur->setLength(9);
        $this->assertSame(9, $dinosaur->getLength());
    }

    public function testDinosaurHasNotShrunk(){

        $dinosaur = new Dinosaur();

        $dinosaur->setLength(15);

        $this->assertGreaterThan(12, $dinosaur->getLength(), "Did you put it in the washing machine?");
    }

    public function testReturnFullSpecificationOfDinosaur(){

        $dinosaur = new Dinosaur();

        $this->assertSame(
            'The Unknown non-carnivorous dinosaur is 0 meters long',
            $dinosaur->getSpecification()
        );
    }

    public function testReturnFullSpecificationForTyrannosaurus(){

        $dinosaur = new Dinosaur('Tyrannosaurus', true);

        $dinosaur->setLength(12);

        $this->assertSame('The Tyrannosaurus carnivorous dinosaur is 12 meters long',
            $dinosaur->getSpecification()
        );
    }

}