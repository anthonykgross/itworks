<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Entity\OAuthToken;
use AppBundle\Entity\Video;
use AppBundle\Form\NoteType;
use AppBundle\Service\Api\Youtube;
use DateInterval;
use DateTime;
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getYoutubeAccessAction(Request $request)
    {
        $client = $this->getGoogleClient();
        return $this->redirect($client->createAuthUrl());
    }

    /**
     * @Route("/youtube/token", name="youtube_get_token")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function tokenAction(Request $request) {
        $client = $this->getGoogleClient();
        $client->fetchAccessTokenWithAuthCode($request->get('code', null));
        $token = $client->getAccessToken();

        try {
            $oauthToken = new OAuthToken();
            $oauthToken->setAccessToken($token['access_token'])
                ->setRefreshToken('fake')
                ->setExpiredAt(new DateTime())
                ->setCreatedAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($oauthToken);
            $em->flush();
        } catch(\Exception $e) {
            dump($e->getMessage());
            exit;
        }


        return $this->redirectToRoute("homepage");
    }


    private function getGoogleClient(){
        /**
         * @var Youtube $service
         */
        $service = $this->get('api.youtube');
        return $service->getInstance()->getOAuthClient();
    }
}
