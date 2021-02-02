<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrarController extends AbstractController
{
    /**
     * @Route("/registrar", name="registrar")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passworEncoder): Response
    {
        $usuario = new User();
        $formulario = $this->createForm(UserType::class, $usuario);
        $formulario->handleRequest($request);
        if ( $formulario->isSubmitted() && $formulario->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $usuario->setPassword($passworEncoder->encodePassword($usuario, $formulario['password']->getData()));
            $em->persist($usuario);
            $em->flush();
            $this->addFlash('exito', User::MSG_REGISTRO_EXITOSO);
            return $this->redirectToRoute('registrar');
        }
        return $this->render('registrar/index.html.twig', [
            'controller_name' => 'RegistrarController',
            'hola' => "Saludando a las personas",
            'form' => $formulario->createView()
        ]);
    }
}
