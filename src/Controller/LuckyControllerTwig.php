<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController 
{
    #[Route("/lucky", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        $kmom01 = file_get_contents('../kmom_text/kmom01.html');
        $kmom02 = file_get_contents('../kmom_text/kmom02.html');
        $kmom03 = file_get_contents('../kmom_text/kmom03.html');
        $kmom04 = file_get_contents('../kmom_text/kmom04.html');
        $kmom05 = file_get_contents('../kmom_text/kmom05.html');
        $kmom06 = file_get_contents('../kmom_text/kmom06.html');
        $kmom10 = file_get_contents('../kmom_text/kmom10.html');
    
        $data = [
            'kmoms' => [
                'kmom01' => "{$kmom01}",
                'kmom02' => "{$kmom02}",
                'kmom03' => "{$kmom03}",
                'kmom04' => "{$kmom04}",
                'kmom05' => "{$kmom05}",
                'kmom06' => "{$kmom06}",
                'kmom10' => "{$kmom10}",
            ]
        ];
    
        return $this->render('report.html.twig', $data);
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }
}