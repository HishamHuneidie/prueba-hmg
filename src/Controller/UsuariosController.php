<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ModificarUsserType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuariosController extends AbstractController
{
    /**
     * @Route("/usuarios", name="usuarios")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios2 = $em->getRepository(User::class)->lista();
        return $this->render('usuarios/index.html.twig', [
            'controller_name' => 'UsuariosController',
            'usuarios2' => $usuarios2,
        ]);
    }

    /**
     * @Route("/ver-usuario/{id}", name="verusuario")
     */
    public function verUsuario ($id, Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(User::class)->find($id);
        $formulario = $this->createForm(ModificarUsserType::class, $usuario);
        $formulario->handleRequest($request);
        if ( $formulario->isSubmitted() && $formulario->isValid() ) {
            if ( trim($formulario['password']->getData()) != '' ) $usuario->setPassword($passwordEncoder->encodePassword($usuario, $formulario['password']->getData()));
            $usuario->setComentario($formulario['comentario']->getData());
            $em->persist($usuario);
            $em->flush();
            $this->addFlash('exito', User::MSG_MODIFICACION_EXITOSO);
            // return $this->redirectToRoute('verusuario');
        }
        return $this->render('usuarios/verUsuario.html.twig', [
            'controller_name' => 'VerUsuario',
            'email' => $usuario->getEmail(),
            'form' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/user/{id}", name="verusuariojson", methods={"GET"})
     */
    public function verUsuarioJson ($id) {

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(User::class)->find($id);
        return $this->render('usuarios/verUsuarioJson.html.twig', [
            'controller_name' => 'VerUsuarioJson',
            'usuario' => $usuario->toArray(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="verusuariojsonpost", methods={"POST"})
     */
    public function verUsuarioJsonPost ($id, Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(User::class)->find($id);
        $password = $request->request->get('password');
        $comentario = $request->request->get('comentario');
        $usuario->setComentario($comentario);
        $usuario->setPassword($passwordEncoder->encodePassword($usuario, $password));
        $em->persist($usuario);
        $em->flush();
        return $this->render('usuarios/verUsuarioJsonPost.html.twig', [
            'controller_name' => 'VerUsuarioJson',
            'usuario' => json_encode($usuario->toArray()),
        ]);
    }

    /**
     * @Route("/confirma-borrar-usuario/{id}", name="confirmaborrarusuario")
     */
    public function confirmaBorrarUsuario ($id, Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(User::class)->find($id);
        return $this->render('usuarios/BorrarUsuario.html.twig', [
            'controller_name' => 'BorrarUsuario',
            'email' => $usuario->getEmail(),
            'id_usuario' => $id,
        ]);
    }

    /**
     * @Route("/borrar-usuario/{id}", name="borrarusuario")
     */
    public function borrarUsuario ($id, Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(User::class)->find($id);
        $em->remove($usuario);
        $em->flush();
        return $this->redirectToRoute('usuarios');
        // return $this->render('usuarios/BorrarUsuario.html.twig', [
        //     'controller_name' => 'BorrarUsuario',
        //     'email' => $usuario->getEmail(),
        // ]);
    }
}
