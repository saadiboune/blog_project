<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"})
     * @param PostRepository $postRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(PostRepository $postRepository, SerializerInterface $serializer): Response
    {
//        $post = $postRepository->findAll();
//        $data = $serializer->serialize($post,'json');
//
//        return new Response($data, Response::HTTP_OK, [
//            "Content-Type" => "application/json"
//        ]);
        return $this -> json($postRepository->findAll(), Response::HTTP_OK, []);

    }
}
