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
    #[Route("/card", name: "card_init_get", methods: ['GET'])]
    public function init(): Response
    {   
        $data = [
            "showdeck" => $this->generateUrl("card_play"),
            "shuffledeck" => $this->generateUrl("card_shuffle"),
        ];
        return $this->render('card.html.twig', $data);
    }

    #[Route("/card", name: "card_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        //Sets the session variable to DeckOfCards()
        $hand = new DeckOfCards();
        $session->set("card_deck", $hand);
        return $this->redirectToRoute('card_play');
    }

    #[Route("/card/deck", name: "card_play", methods: ['GET'])]
    public function play_deck(
        SessionInterface $session
    ): Response
    {
        //Retrieves the session variable current_deck
        $current_deck = $session->get("card_deck");

        $data = [
            "init_deck" => $current_deck->get_deck() 
        ];

        return $this->render('card/card_deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle", methods: ['GET'])]
    public function shuffle(
        SessionInterface $session
    ): Response
    {
        $shuffle_deck = $session->get("card_deck");

        $data = [
            "shuffled_deck" => $shuffle_deck->shuffle_deck() 
        ];
        return $this->render('card/shuffled_card_deck.html.twig', $data);
    }
}