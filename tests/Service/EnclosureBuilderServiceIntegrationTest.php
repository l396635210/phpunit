<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 5/29/18
 * Time: 6:05 AM
 */

namespace App\Tests\Service;



use App\Entity\Dinosaur;
use App\Entity\Security;
use App\Service\EnclosureBuilderService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{

    /**
     * @var EntityManager
     */
    private $em;

    public function setUp()
    {
        self::bootKernel();
        $this->em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->truncateEntities();
    }

    private function truncateEntities()
    {
        $purger = new ORMPurger($this->em);
        $purger->purge();
    }

    public function testItBuildsEnclosureWithDefaultSpecifications(){

        /**
         * @var $builder EnclosureBuilderService
         */
        $builder = self::$kernel->getContainer()
            ->get('test.'.EnclosureBuilderService::class);

        $enclosure = $builder->buildEnclosure();

        $count = (int)$this->em->getRepository(Security::class)
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(1, $count, 'Amount of security systems is not same');

        $count = (int)$this->em->getRepository(Dinosaur::class)
            ->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(3, $count, 'Amount of Dinosaur systems is not same');

        $this->assertCount(3, $enclosure->getDinosaurs());
    }

}