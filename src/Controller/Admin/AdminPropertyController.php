<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends  AbstractController
{
    private PropertyRepository $repository;

    /**
     * @param PropertyRepository $repository
     */
    public function __construct(PropertyRepository $repository)
    {
    $this->repository = $repository;
    }
    #[Route('/admin', name: 'admin.property.index')]
    public function index(): Response
    {
        $property = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig',  [
            'current_menu' => 'properties',
            'properties' => $property
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    #[Route('/admin/new', name: 'admin.property.new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($property);
            $em->flush();
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/create.html.twig',  [
            'properties' => $property,
            'form' => $form->createView(),
            'current_menu' => 'properties',
        ]);
    }
    #[Route('/admin/{id}', name: 'admin.property.edit')]
    public function edit(Property $property, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig',  [
            'properties' => $property,
            'form' => $form->createView(),
            'current_menu' => 'properties',
        ]);
    }
}