<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Serializable;

interface iMastermind extends Serializable { // sauver en session
    public function __construct($taille=4); // crée un nouveau jeu
    public function test($code); // teste une proposition
    public function getEssais(); // ret les prop. préc.
    public function getTaille(); // taille du jeu (4)
    public function isFini(); // vrai si jeu fini : 4 bien placés
}

class Mastermind implements iMastermind
{
    // session
    // private $requestStack;
    /** code à découvrir chaine de car compris entre 0 et 9 */
    protected $code="";

    /** liste des essais */
    protected $lessai=array();

    protected $isFini=false;

    /** constructeur par défaut : génération d'un code aléatoire de taille
     * chiffres différents 
     */ 
    public function __construct($taille=4){
        // $this->requestStack = $requestStack;
        for($i=0; $i<$taille; $i++){
            $c=rand(0,9);		// nouveau chiffre
            $this->code.="$c";
        }
        dump($this->code);
    }
    
    /** teste une chaîne de caractères par rapport au code et retourne un
     * tableau de 2 entiers : ( nb de chiffres bien placés, nb de chiffres mal 
     * placés ou false si invalide
     */
    public function test($essai){
        $cessai=$essai; // copie car modifié	
        $ccode=$this->code; // copie car modifié
        $res=array_fill_keys(array("bon", "mal"), 0);
        if(!$this->valide($essai)) {
            $res=array("bon"=>0, "mal"=>0);
            return false;
        }

        for($i=0; $i<strlen($cessai); $i++){ // boucle des biens placés
            if($ccode[$i]==$cessai[$i]){
                $ccode[$i]='Y'; // afin de ne plus le prendre en compte
                $cessai[$i]='Y'; // afin de ne plus le prendre en compte
                $res["bon"]++;
            }
        } // fin de la boucle des biens placés
        for($i=0; $i<strlen($cessai); $i++){ // boucle des mals placés
            if($cessai[$i]!='Y'){
                $pos = strpos($ccode,$cessai[$i]);
                if (!($pos === false)) {
                    $res["mal"]++;
                    $ccode[$pos]='Y';
                }
            }
        } // fin de boucle des mals placés
        $this->lessai[$essai]=$res;
        if($this->lessai[$essai]["bon"]===$this->getTaille() && 
            $this->lessai[$essai]["mal"]===0) {
            $this->isFini = true;
        }
        return $res;
    }

    /** retourne la taille du code */
    public function getTaille () {
        return strlen($this->code);
    }
    public function getEssais () {
        return $this->lessai;
    }

    /** teste la validité d'une chaîne code et retourne un booléen :
     * - que des chiffres ;
     * - de même taille que $this->code
     */ 
    public function valide($code){
        if(!is_string($code) || strlen($code)!=strlen($this->code) 
            || !ctype_digit($code)){
            return false;
        }
        return true;
    }

    public function isFini() {
        return $this->isFini;
    }

    public function serialize()
    {
        return serialize(array(
            $this->code,
            $this->lessai,
            $this->isFini,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->code,
            $this->lessai,
            $this->isFini,
        ) = unserialize($serialized);
    }
}
