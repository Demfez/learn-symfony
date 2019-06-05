<?php
// src/Controller/RandomNumberController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RandomNumberController extends AbstractController
{
    /**
     * @Route("/random_number", name="random_number")
     */
    public function number()
    {
        $number = random_int(0, 100);

        return $this->render('random_number.html.twig', [
            'number' => $number
        ]);
    }
}