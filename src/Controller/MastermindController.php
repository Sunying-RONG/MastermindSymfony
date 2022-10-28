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
        $session->set('test', 'testContent');
        dump($session);
        // $session = new Session(new PhpBridgeSessionStorage());
        // $session->start();
        $jeu;
        // $valide;
        // $session->clear();
        if ($session->has('mm')) {
            if ($session->get('mm') === null) {
                $session->clear();

                $this->jeu = new Mastermind();
                $session->set('mm', $this->jeu);
                dump("delete null jeu, create jeu");
                dump($session->get('mm'));
            } else {
                $this->jeu = $session->get('mm');
                dump("has jeu");
                dump($session->get('mm'));
                dump($session->getMetadataBag()->getLifetime());
            }
            
        } else {
            $this->jeu = new Mastermind();
            $session->set('mm', $this->jeu);
            dump("no jeu, create jeu");
            dump($session->get('mm'));
        }
        if ($request->query->get('prop') !== null) {
            $valide = $this->jeu->valide($request->query->get('propo'));
            if ($valide) {
                $this->jeu->test($request->query->get('propo'));
            }
            dump($session->get('jeu'));
        }
        if ($request->query->get('nouveau') !== null) {
            $this->jeu = new Mastermind();
            $session->set('jeu', $this->jeu);
        }
        // dump($this->jeu);
        return $this->render('mastermind/index.html.twig', [
            'taille'=>$this->jeu->getTaille(),
            'isFini'=>$this->jeu->isFini(),
            'lessai'=>$this->jeu->getEssais(),
            // 'valide'=>$valide,
        ]);
    }
   
}
