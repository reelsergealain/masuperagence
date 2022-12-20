<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home.index')]
    public function index(Request $request): Response
    {

        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'constraints' => new NotBlank,
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'placeholder' => 'Choose a country',
                'query_builder' => function (CountryRepository $countryRepository) {
                    return $countryRepository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                }
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'placeholder' => 'Choose a country',
                'disabled' => true,
                'query_builder' => function (CityRepository $cityRepository) {
                    return $cityRepository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                }
            ])
            // ->addEventListener(FormEvents::PRE_SET_DATA, fn (FormEvent $event)
            // => )
            // ->addEventListener(FormEvents::POST_SET_DATA, fn() => dump('hello post data'))
            ->add('message', TextareaType::class, [
                'attr' => ['rows' => 5]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }
        return $this->renderForm('home/index.html.twig', [
            'form' => $form,
            'current_menu' => 'home',
        ]);
    }
}
