<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Entity\Video;
use AppBundle\Form\NoteType;
use Google_Client;
use Google_Service_YouTube;
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

    /**
    * @Route("/youtube/connect", name="youtube_connect")
    */
    public function getYoutubeAccessAction(Request $request)
    {
        $client = $this->getGoogleClient();
        return $this->redirect($client->createAuthUrl());
    }

    /**
     * @Route("/youtube/token", name="youtube_get_token")
     */
    public function tokenAction(Request $request) {
        $client = $this->getGoogleClient();
        $client->fetchAccessTokenWithAuthCode($request->get('code', null));

        dump($client->getAccessToken());
        dump($client->getRefreshToken());
        exit;
    }


    private function getGoogleClient(){
        $clientId = $this->getParameter('youtube_client_id');
        $clientSecret = $this->getParameter('youtube_client_secret');

        $client = new Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);

        $client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');
        $redirect = 'http://localhost/app_dev.php/youtube/token';
        $client->setRedirectUri($redirect);
        return $client;
    }
}
