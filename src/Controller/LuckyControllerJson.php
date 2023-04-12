<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api/quote")]
    public function jsonNumber(): Response
    {

        $c1 = "Keep your friends close, but your enemies closer.";
        $c2 = "All that glitters is not gold.";
        $c3 = "If you want something done right, do it yourself.";
        $date = date("Y-m-d");
        $time = date("h:i:sa");

        $input = array($c1, $c2, $c3);
        $a = array_rand($input, 1);

        $data = [
            'Random quote' => $input[$a],
            'Current date' => $date,
            'Current time' => $time
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
