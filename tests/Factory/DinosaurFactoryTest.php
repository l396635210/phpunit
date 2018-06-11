<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/23/18
 * Time: 6:46 AM
 */

namespace App\Tests\Factory;


use App\Entity\Dinosaur;
use App\Factory\DinosaurFactory;
use App\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DinosaurFactoryTest extends TestCase
{

    /**
     * @var MockObject
     */
    private $lengthDeteminator;

    /**
     * @var DinosaurFactory
     */
    private $factory;

    public function setUp()
    {
        $this->lengthDeteminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($this->lengthDeteminator);
    }

    public function testItGrowsALargeVelociraptor(){

        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }

    public function testItGrowsATriceraptors(){
        $this->markTestIncomplete('Waiting for confirmation from GenLab');
    }

    public function testItGrowsABabyVelociraptor(){

        if (!class_exists('Nanny')){
            $this->markTestSkipped('There is nobody to watch the baby');
        }

        $dinosaur = $this->factory->growVelociraptor(1);

        $this->assertSame(1, $dinosaur->getLength());
    }


    public function getSpecificationTests(){
        return [
            # specification                is carnivorous
            ['large carnivorous dinosaur', true],
            ['large herbivore',            false],
            ['give me cookies!!',          false],
        ];
    }

    /**
     * @dataProvider getSpecificationTests
     * @param string $spec
     * @param bool $expectedIsCarnivorous
     */
    public function testItGrowsADinosaurFromSpecification(string $spec, bool $expectedIsCarnivorous){

        $this->lengthDeteminator->expects($this->once())->method('getLengthFromSpecification')
            ->with($spec)
            ->willReturn(22);

        $dinosaur = $this->factory->growFromSpecification($spec);

        $this->assertEquals(22, $dinosaur->getLength());
        $this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'Diets do match');

    }

}