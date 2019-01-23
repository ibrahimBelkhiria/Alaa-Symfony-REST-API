<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ArticleController extends AbstractFOSRestController
{

    /**
     *
     * @Rest\Get("/api/articles",name="all_articles")
     *
     * @return View
     *
     */
    public function indexAction()
    {

        $entityManager = $this->getDoctrine()->getManager();

        $articles = $entityManager->getRepository(Article::class)->findAll();

        // new JsonResponse($articles,Response::HTTP_OK);
        return View::create($articles,Response::HTTP_OK);

    }

    /**
     * @param $id
     * @Rest\Get("/api/articles/{id}",name="get_one_article_by_id")
     * @return View
     */
    public function getArticleById($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);

        return View::create($article,Response::HTTP_OK);

    }


    /**
     * @Rest\Post("/api/articles",name="create_article")
     * @param Request $request
     * @return View
     */

    public  function createArticle(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setName($request->get('name'));
        $article->setDescription($request->get('description'));

        $entityManager->persist($article);

        $entityManager->flush();

        return View::create($article,Response::HTTP_CREATED);

    }

    /**
     * @Rest\Put("/api/articles/{id}",name="update_article")
     * @param Request $request
     * @param $id
     * @return View
     */

    public  function updateArticle(Request $request,$id)
    {

         $entityManager = $this->getDoctrine()->getManager();
         $articleRepo = $entityManager->getRepository(Article::class);


        $article = $articleRepo->find($id);
        $article->setName($request->get('name'));
        $article->setDescription($request->get('description'));

       // $entityManager->persist($article);

        $entityManager->flush();

        return View::create($article,Response::HTTP_OK);

    }

    /**
     * @Rest\Delete("/api/articles/{id}",name="remove_article")
     * @param $id
     * @return View
     */
    public function removeArticle($id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $articleRepo = $entityManager->getRepository(Article::class);


        $article = $articleRepo->find($id);

        $entityManager->remove($article);

        $entityManager->flush();


        return View::create([],Response::HTTP_NO_CONTENT);

    }






}
