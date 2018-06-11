<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/28/18
 * Time: 6:06 AM
 */

namespace App\Service;


use App\Entity\Dinosaur;

class DinosaurLengthDeterminator
{


    public function getLengthFromSpecification(string $specification): int
    {
        $availableLengths = [
            'large' => [ 'min'=> Dinosaur::LARGE, 'max' => Dinosaur::HUGE-1 ],
            'huge'  => [ 'min'=> Dinosaur::HUGE,  'max' => 100 ],
            'OMG'   => [ 'min'=> Dinosaur::HUGE,  'max' => 100 ],
            '😱'    => [ 'min'=> Dinosaur::HUGE,  'max' => 100 ],
        ];

        $minLength = 1;
        $maxLength = Dinosaur::LARGE - 1;

        foreach ($availableLengths as $name => $length){
            if (stripos($specification, $name) !== false){
                $minLength = $length['min'];
                $maxLength = $length['max'];
                break;
            }
        }

        return random_int($minLength, $maxLength);
    }


}