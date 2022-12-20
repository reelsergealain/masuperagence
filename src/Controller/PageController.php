<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/', name: 'page.index')]
    public function index(PropertyRepository $propertyRepository): Response
    {
        $property = $propertyRepository->findallActive();
        return $this->render('page/index.html.twig', [
            'current_menu' => 'page',
            'properties' => $property,
        ]);
    }
}
