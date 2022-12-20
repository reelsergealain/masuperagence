<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    #[Route('/biens', name: 'property.index')]
    public function index(PropertyRepository $propertyRepository): Response
    {
        $property = $propertyRepository->findallActive();
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $property,
        ]);
    }

    #[Route('/bien/{slug}-{id}', name: 'property.show', requirements: ['slug' => "[a-z0-9\-]*"])]
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
           return  $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property,
        ]);
    }
}
