<?php

namespace AR\UserBundle\Controller;

use AR\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login" )
     * @Template()
     */
    public function loginAction()
    {
        // On récupère les erreurs d'authenfication si le formulaire a été passé avec de mauvaises informations
        if($this->get('request')->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)){
            $error = $this->get('request')->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else{
            $error = $this->get('request')->getSession()->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        }

        return array(
            // On envoie à notre vue le login qu'a saisi l'utilisateur précédemment
            'last_username' => $this->get('request')->getSession()->get(SecurityContextInterface::LAST_USERNAME),
            // Et les erreurs qu'il y a eut lors de la validation du formalaire
            'error'         => $error,
        );
    }


}
