<?php

namespace AppBundle\Controller;

use AppBundle\Forms\MakeNurlType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homeAction(Request $request)
    {
        $mgr= $this->getDoctrine()->getManager();
        $n = $mgr->getRepository('AppBundle:Nurl')->findAll();
        return $this->render('default/index.html.twig', [
            'nurls' => $n
        ]);
    }

    /**
     * @Route("/makenurl", name="make_nurl_form")
     * @Method({"GET"})
     */
    public function makeNurlFormAction(Request $request)
    {
        $form = $this->createForm(MakeNurlType::class);

        return $this->render('default/make_nurl.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/makenurl", name="make_nurl")
     * @Method({"POST"})
     */
    public function makeNurlAction(Request $request)
    {
        $form = $this->createForm(MakeNurlType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $nurl = $form->getData();

            $user = $this->getUser();

            $manager = $this->getDoctrine()->getManager();

            if ($user && $user->hasRole('ROLE_USER')) {
                $nurl->setAccepted(true);
                $nurl->setUser($user);
                $manager->persist($user);
            }

            $manager->persist($nurl);

            $manager->flush();
        }

        return $this->redirectToRoute('homepage');
    }
}
