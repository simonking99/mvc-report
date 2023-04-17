<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class CardGameController extends AbstractController
{
    #[Route("/game/card", name: "card_start", methods: ['GET'])]
    public function card_start(): Response
    {
        return $this->render('card.html.twig');
    }
    
    //Route där jag skapar sessionvariabel och tilldelar värde.
    #[Route("/game/card", name: "card_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $deck = new DeckOfCards();
        $session->set("pig_dicehand", $deck);
        return $this->redirectToRoute('card_play');
    }

    //Route där jag hämtar sessionvariabel
    #[Route("/game/card/card_deck", name: "card_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response
    {
        $dicehand = $session->get("pig_dicehand");

        $data = [
            "diceValues" => $dicehand->get_deck()
        ];

        return $this->render('card/card_deck.html.twig', $data);
    }
}