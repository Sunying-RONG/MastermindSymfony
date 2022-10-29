<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Serializable;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Mastermind;

class MastermindController extends AbstractController
{
    #[Route('/', name: 'app_mastermind')]
    public function index(SessionInterface $session, Request $request): Response
    {
        // dump($session);
        // $session = new Session(new PhpBridgeSessionStorage());
        // $session->start();
        $jeu;
        // $valide;
        // $session->clear();
        if ($session->has('mm') && $session->get('mm') !== null) {
            $this->jeu = $session->get('mm');
            dump("has jeu");
            dump($session->get('mm'));
            dump($session->getMetadataBag()->getLifetime());
        } else {
            $this->jeu = new Mastermind();
            $session->set('mm', $this->jeu);
            dump("create jeu");
            dump($session->get('mm'));
        }

        // dump($request->request->all());
        $valide=false;
        $essai = $request->request->get('prop');
        if ($essai !== null) {
            $valide = $this->jeu->valide($essai);
            if ($valide) {
                $this->jeu->test($essai);
            }
            dump($session->get('mm'));
        }
        if ($request->request->get('nouveau') !== null) {
            $this->jeu = new Mastermind();
            $session->set('mm', $this->jeu);
        }
        // dump($this->jeu);
        return $this->render('mastermind/index.html.twig', [
            'taille'=>$this->jeu->getTaille(),
            'isFini'=>$this->jeu->isFini(),
            'lessai'=>$this->jeu->getEssais(),
            'valide'=>$valide,
            'essai'=>$essai
        ]);
    }
   
}
