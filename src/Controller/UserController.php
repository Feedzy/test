<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{

     private $passwordEncoder;
 
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    public function inscription(request $req)
    {
        $user = new User();
        $formulaire = $this->createForm(UserType::class, $user);
        $formulaire->handleRequest($req);
         if ($formulaire->isSubmitted() && $formulaire->isValid())
        {
            
            $password = $user->getPassword();
            $user->setPassword($this->passwordEncoder->encodePassword($user,$password ));
            $user->setRoles(['ROLE_ADMIN']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            echo "<script> alert('iinscription reussi') </script>";
            return $this->redirectToRoute('connexion');
        }
        return $this->render('user/inscription.html.twig',[
            'formulaire'=>$formulaire->createView()
        ]);
    }
}
