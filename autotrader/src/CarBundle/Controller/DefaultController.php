<?php

namespace CarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends Controller
{
    /**
     * @Route("/our-cars", name="offer")
     */
    public function indexAction()
    {
        $carRepo = $this->getDoctrine()->getRepository('CarBundle:Car');
        $cars = $carRepo->findCarsWithDetails();

        $form = $this->createFormBuilder()
            ->add('search',TextType::class)
            ->getForm();

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
