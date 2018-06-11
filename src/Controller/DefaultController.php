<?php
/**
 * Created by PhpStorm.
 * User: lz
 * Date: 6/10/18
 * Time: 3:14 PM
 */

namespace App\Controller;


use App\Entity\Enclosure;
use App\Factory\DinosaurFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request){

        $enclosures = $this->getDoctrine()->getRepository(Enclosure::class)
            ->findAll();

        return $this->render('default/index.html.twig', [
            'listData' => $enclosures,
        ]);
    }

    /**
     * @param Request $request
     * @param DinosaurFactory $dinosaurFactory
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \App\Exception\NotABuffetException
     * @Route("/grow", name="grow_dinosaur")
     * @Method({"POST"})
     */
    public function growAction(Request $request, DinosaurFactory $dinosaurFactory){

        $em = $this->getDoctrine()->getManager();

        $enclosure = $em->getRepository(Enclosure::class)
            ->find($request->request->get('enclosure'));

        $specification = $request->request->get('specification');

        $dinosaur = $dinosaurFactory->growFromSpecification($specification);

        $dinosaur->setEnclosure($enclosure);
        $enclosure->addDinosaur($dinosaur);

        $em->flush();

        $this->addFlash('success', sprintf(
            'Grew a %s in enclosure #%d',
            mb_strtolower($specification),
            $enclosure->getId()
        ));

        return $this->redirectToRoute('homepage');
    }

}