<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Nurl;
use AppBundle\Entity\Tag;
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
        $tags = $this->getDoctrine()->getRepository('AppBundle:Tag')->findAll();

        $form = $this->createForm(MakeNurlType::class, new Nurl(), [
            'tags' => $tags
        ]);

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

        if($form->isSubmitted()) {

            $nurl = $form->getData();

            $user = $this->getUser();

//            $tags = $form->get('tags')->getData();

            $manager = $this->getDoctrine()->getManager();

            if ($user && $user->hasRole('ROLE_USER')) {
                $nurl->setAccepted(true);
                $nurl->setUser($user);
                $manager->persist($user);
            }

            $manager->persist($nurl);

            $manager->flush();
        }

        if($form->isSubmitted() && !$form->isValid()) {

            return $this->render('default/error.html.twig', [
                'text' => 'Invalid form submitted.'
            ]);
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/viewtags", name="view_tags")
     */
    public function viewTagsAction(Request $request)
    {
        $tags = $this->getDoctrine()->getRepository('AppBundle:Tag')->findAll();

        return $this->render('default/tags.html.twig', [
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/maketag", name="make_tag")
     * @Method({"POST"})
     */
    public function makeTagAction(Request $request)
    {
        $title = $request->get('title');

        $user = $this->getUser();

        $manager = $this->getDoctrine()->getManager();

        $tag = new Tag();

        $tag->setTitle($title);

        if($user) {
            $tag->setUser($user);
            $tag->setAccepted(true);
            $manager->persist($user);
        }

        $manager->persist($tag);

        $manager->flush();

        return $this->redirectToRoute('view_tags');
    }
}
