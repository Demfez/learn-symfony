<?php

// src/Controller/ProductController.php
namespace App\Controller;

// ...
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductController extends AbstractController
{
    /**
     * @Route("/product_new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function create(Request $request)
    {
        $product = new Product();

        $form = $this->createFormBuilder($product)
        ->add('name', TextType::class, ['attr' => [
            'class'=>'form-control'
        ]])
        ->add('price', TextType::class, [
            'required' => false,
            'attr' => [
                'class'=>'form-control'
            ]
        ])
        ->add('description', TextareaType::class, [
            'required' => false,
            'attr' => [
                'class'=>'form-control'
            ]
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Create',
            'attr' => ['class' => 'btn btn-primary']
        ])
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('/product/create.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/product/{id<\d+>}", name="product_show")
     * @param $id
     * @return string
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

//        $json_product = $serializer->serialize($product, 'json');
//        return new Response($json_product);
        return $this->json($product);

    }

    /**
     * @Route("/product/show_all")
     * @return Response
     */
    public function showAll()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('product/show_all.html.twig', ['products' => $products]);
    }
}