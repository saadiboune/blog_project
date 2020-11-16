<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Forms;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('posts/index.html.twig', ['posts' => $postRepository -> findAll()]);
    }

    /**
     * @Route("/post/{id<\d+>}", name="app_post_details")
     * @param Post $post
     * @return Response
     */
    public function getPost(Post $post): Response {
//        getPin(PinRepository $pinRepository, int $id)
//        $pin = $pinRepository -> find($id);
//        if(! $pin) {
//            throw $this -> createNotFoundException('Pin ' . $id . ' Not Found');
//        }
        return $this -> render('posts/postDetails.html.twig', compact('post'));
    }

    /**
     * @Route("/post/create", name="app_post_create", methods={"GET", "POST", "PATCH"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     * @throws Exception
     */
    public function create(Request $request, EntityManagerInterface $em) {
        $post = new Post;
        $form = $this -> createFormBuilder($post)
            -> add('titre', null, [
                'attr' =>['autofocus' => true]])
            ->add('url_alias')
            ->add('content', null, ['attr' => ['rows' => 10, 'cols' => 50]])
//            ->add('published', DateType::class, [
//                'widget' => 'single_text',
//            ])
            -> getForm()
        ;
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {
            $post -> setPublished(new \DateTime());
            $em -> persist($post);
//            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('app_post_details', ['id' => $post -> getId()]);
        }
        return $this->render('posts/create.html.twig', [
            'postForm' => $form -> createView()
        ]);
    }
}
