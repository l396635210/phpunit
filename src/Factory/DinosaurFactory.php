<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/23/18
 * Time: 7:00 AM
 */

namespace App\Factory;


use App\Entity\Dinosaur;
use App\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{

    /**
     * @var DinosaurLengthDeterminator
     */
    private $lengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $determinator)
    {
        $this->lengthDeterminator = $determinator;
    }

    private function createDinosaur(string $genus, bool $isCarnivorous, int $length){
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLength($length);

        return $dinosaur;
    }

    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification($specification)
    {
        $isCarnivorous = false;
        $codeName = 'InG-'.random_int(1, 9999);
        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);

        if (stripos($specification, 'carnivorous') !== false){
            $isCarnivorous = true;
        }


        return $this->createDinosaur($codeName, $isCarnivorous, $length);
    }

}