<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Entity\Video;
use AppBundle\Form\NoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $search = $request->query->get('q', null);
        $search = (strlen($search)>0)?$search:null;

        $videos = $em->getRepository(Video::class)->search($search);

        return $this->render(
            'default/list.html.twig',
            array(
                'videos' => $videos,
                'search' => $search
            )
        );
    }

    /**
     * @Route("/video/{id}", name="video")
     * @param Video $video
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function videoAction(Video $video, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = null;

        if ($user) {
            $note = $em->getRepository(Note::class)->findOneBy(array(
                'user' => $user,
                'video' => $video
            ));

            if (!$note) {
                $note = new Note();
                $note->setUser($user)
                    ->setVideo($video);
            }

            $form = $this->createForm(NoteType::class, $note);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($note);
                $em->flush();

                return $this->redirectToRoute('video', array('id' => $video->getId()));
            }

            $form = $form->createView();
        }

        return $this->render(
            'default/video.html.twig',
            array(
                'video' => $video,
                'user' => $user,
                'form' => $form
            )
        );
    }
}
