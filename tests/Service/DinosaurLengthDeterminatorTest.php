<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/28/18
 * Time: 6:07 AM
 */

namespace App\Tests\Service;


use App\Entity\Dinosaur;
use App\Service\DinosaurLengthDeterminator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DinosaurLengthDeterminatorTest extends TestCase
{

    public function itReturnCorrectLengthRangeTests(){
        return [

            # specification                min large               max length
            ['large carnivorous dinosaur', Dinosaur::LARGE,        Dinosaur::HUGE],
            ['large herbivore',            Dinosaur::LARGE,        Dinosaur::HUGE],
            ['give me cookies!!',          1,                      Dinosaur::LARGE],
            ['huge',                       Dinosaur::HUGE,         100],
            ['OMG',                        Dinosaur::HUGE,         100],
        ];
    }

    /**
     * @param string $spec
     * @param int $expectedMinLength
     * @param int $expectedMaxLength
     * @dataProvider itReturnCorrectLengthRangeTests
     */
    public function testItReturnCorrectLengthRange(string $spec, int $expectedMinLength, int $expectedMaxLength){

        $determinator = new DinosaurLengthDeterminator();
        $length = $determinator->getLengthFromSpecification($spec);

        $this->assertGreaterThanOrEqual($expectedMinLength, $length);
        $this->assertLessThanOrEqual($expectedMaxLength, $length);
    }

}