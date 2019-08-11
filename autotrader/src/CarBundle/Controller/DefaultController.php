<?php

namespace CarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;


class DefaultController extends Controller
{
    /**
     * @Route("/our-cars", name="offer")
     */
    public function indexAction(Request $request)
    {
        $carRepo = $this->getDoctrine()->getRepository('CarBundle:Car');
        $cars = $carRepo->findCarsWithDetails();

        $form = $this->createFormBuilder()
            ->setMethod('GET')
            ->add('search',TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2])
                ]
            ])
            ->getForm();


        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            die('Form Submitted');
        }

        return $this->render('@Car/Default/index.html.twig',[
            'cars' => $cars,
            'form' => $form->createView()
        ]);   
    }

    /**
     * @Route("/car/{id}", name="show_car")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCar($id)
    {
        $carRepo = $this->getDoctrine()->getRepository('CarBundle:Car');
        $car = $carRepo->findCarsWithDetailsById($id);
        return $this->render('@Car/Default/show.html.twig',['car' => $car]);
    }




}
