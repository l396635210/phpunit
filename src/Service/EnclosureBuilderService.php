<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/28/18
 * Time: 6:32 AM
 */

namespace App\Service;


use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Entity\Security;
use App\Factory\DinosaurFactory;
use Doctrine\ORM\EntityManagerInterface;

class EnclosureBuilderService
{

    private $em;

    private $dinosaurFactory;

    public function __construct(EntityManagerInterface $entityManager, DinosaurFactory $dinosaurFactory)
    {
        $this->em = $entityManager;
        $this->dinosaurFactory = $dinosaurFactory;
    }

    public function buildEnclosure(int $numbersOfSecurities = 1, int $numbersOfDinosaurs = 3){
        $enclosure = new Enclosure();

        $this->addEnclosureSecurities($enclosure, $numbersOfSecurities);


        $this->addEnclosureDinosaurs($enclosure, $numbersOfDinosaurs);

        $this->em->persist($enclosure);
        $this->em->flush();

        return $enclosure;

    }

    private function addEnclosureSecurities(Enclosure $enclosure, int $numbersOfSecurities){

        foreach (range(1, $numbersOfSecurities) as $number){
            $name = ['Fence', ][random_int(0,0)];
            $enclosure->addSecurity(new Security($name, true, $enclosure));
        }

    }

    /**
     * @param int $numbersOfDinosaurs
     * @param $enclosure
     * @throws \Exception
     */
    private function addEnclosureDinosaurs(Enclosure $enclosure, int $numbersOfDinosaurs): void
    {
        $diet = ['herbivore', 'carnivorous'][random_int(0, 1)];
        foreach (range(1, $numbersOfDinosaurs) as $number) {
            $length = ['small', 'large', 'huge',][random_int(0, 2)];
            $specification = "${length} ${diet} dinosaur";
            $dinosaur = $this->dinosaurFactory->growFromSpecification($specification);
            $dinosaur->setEnclosure($enclosure);
            $enclosure->addDinosaur($dinosaur);
        }
    }


}