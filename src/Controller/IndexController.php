<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    /**
     * @Route("/producto/{reactRouting}/show/", name="showIndex")
     */
    public function showIndex()
    {
        return $this->render('index/index.html.twig');
    }
    /**
     * @Route("/producto/{reactRouting}/edit/", name="editIndex")
     */
    public function editIndex()
    {
        return $this->render('index/index.html.twig');
    }
    /**
     * @Route("/producto/{reactRouting}", name="newIndex")
     */
    public function newIndex()
    {
        return $this->render('index/index.html.twig');
    }
    /**
     * @Route("/{reactRouting}", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig');
    }
}
