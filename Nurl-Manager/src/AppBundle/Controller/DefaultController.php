<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Nurl;
use AppBundle\Entity\Report;
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
        $n = $mgr->getRepository('AppBundle:Nurl')->findBy(['frozen' => false]);
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

    /**
     * @Route("/tagup", name="up_vote")
     */
    public function tagUpAction(Request $request)
    {
        $user = $this->getUser();

        $mgr = $this->getDoctrine()->getManager();

        $tag = $mgr->getRepository('AppBundle:Tag')->find($request->get('id'));

        if($user) {
            $tag->setVotes($tag->getVotes() + 5);
        } else {
            $tag->setVotes($tag->getVotes() + 1);
        }

        $mgr->persist($tag);

        $mgr->flush();

        return $this->redirectToRoute('view_tags');
    }

    /**
     * @Route("/tagdown", name="down_vote")
     */
    public function tagDownAction(Request $request)
    {
        $user = $this->getUser();

        $mgr = $this->getDoctrine()->getManager();

        $tag = $mgr->getRepository('AppBundle:Tag')->find($request->get('id'));

        if($user) {
            $tag->setVotes($tag->getVotes() - 5);
        } else {
            $tag->setVotes($tag->getVotes() - 1);
        }

        $mgr->persist($tag);

        $mgr->flush();

        return $this->redirectToRoute('view_tags');
    }

    /**
     * @Route("/reportform", name="report_form")
     */
    public function reportFormAction(Request $request)
    {
        $id = $request->get('id');

        return $this->render('default/report.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/report/{id}", name="report")
     * @Method({"POST"})
     */
    public function reportAction(Request $request)
    {
        $id = $request->get('id');
        $message = $request->get('message');

        $email = $request->get('email');

        $mgr = $this->getDoctrine()->getManager();

        $report = new Report();

        $report->setMessage($message);
        $report->setEmail($email);

        $nurl = $mgr->getRepository('AppBundle:Nurl')->find($id);

        $report->setNurl($nurl);

        $nurl->setFrozen(true);

        $mgr->persist($report);

        $mgr->persist($nurl);

        $mgr->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $text = $request->get('text');

        $mgr = $this->getDoctrine()->getManager();

        $nurls = $mgr->getRepository('AppBundle:Nurl')->findAll();

        $nurls = array_filter($nurls, function($nurl) use ($text) {
            $t = $nurl->getTitle();
            $s = $nurl->getSummary();
            $b = $nurl->getBody();
            if(strpos($t, $text) !== false) {
                return true;
            }

            if(strpos($t, $text) !== false) {
                return true;
            }


            if(strpos($t, $text) !== false) {
               return true;             
             }

             return false;
        });

        return $this->render('default/index.html.twig', [
            'nurls' => $nurls,
            'hl' => true
        ]);
    }

    /**
     * @Route("/delete", name="delete_nurl")
     * @Method({"POST"})
     */
    public function deleteNurl(Request $request)
    {
        $id = $request->get('id');

        $user = $this->getUser();

        $manager = $this->getDoctrine()->getManager();

        $nurl = $manager->getRepository('AppBundle:Nurl')->find($id);

        $author = $nurl->getUser();

        if($author->getId() === $user->getId()) {
            $manager->remove($nurl);

            $manager->flush();
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/delete_account", name="delete_account_form")
     * @Method({"GET"})
     */
    public function deleteAccountFormAction(Request $request)
    {
        return $this->render('default/delete_account.html.twig');
    }

    /**
     * @Route("/delete_account", name="delete_account")
     * @Method({"POST"})
     */
    public function deleteAccountAction(Request $request)
    {
        $user = $this->getUser();

        $mgr = $this->getDoctrine()->getManager();

        $mgr->remove($user);

        $mgr->flush();

        return $this->redirectToRoute('homepage');
    }
}
