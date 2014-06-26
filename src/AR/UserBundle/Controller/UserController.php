<?php

namespace AR\UserBundle\Controller;

use AR\UserBundle\Entity\Role;
use AR\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Validator\Constraints\DateTime;

class UserController extends Controller
{
    /**
     * @Route("/createUser/{login}-{password}-{email}")
     * @Template()
     */
    public function createUserAction($login, $password, $email)
    {
        $user = new User();
        $role = new Role();
        $role->setName('ROLE_ADMIN');

        $user->setUserName($login);
        $user->setEmail($email);
        $user->addRole($role);

        $salt = md5(time());
        $user->setSalt($salt);
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return array();
    }

}
