<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameControllerJson extends AbstractController
{
    #[Route("/api", name: "api")]
    //Base route
    public function api(): Response
    {
      return $this->render('api.html.twig');
    }

    #[Route("/api/deck", name: "api_deck_sorted", methods: ['GET'])]
    //Route to show deck
    public function getSortedDeck(): Response
    {
        $deck = new DeckOfCards();

        $response = new JsonResponse($deck->get_deck());
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffled", methods: ['POST'])]
    //Route to show a shuffled deck
    public function postShuffledDeck(
      SessionInterface $session
      ): Response
    {
      $deck = new DeckOfCards();
      $session->set("deck", $deck);
      $deck = $session->get("deck");

      if (!$deck) {
          $deck = new DeckOfCards();
          $session->set("deck", $deck);
      }
        $shuffled_deck = $deck->shuffle_deck();

        return $this->json([
            'deck' => $shuffled_deck,
        ]);
  }

    #[Route("/api/deck/draw", name: "api_card_draw", methods: ['POST'])]
    //Route to draw a card from the deck
    public function draw_card(
      SessionInterface $session
      ): Response
    {
        $deck = $session->get("deck");
        $response = [
            'drawn_card' => $deck->draw_card(),
            'amount_of_cards_left' => $deck->count(),
        ];

        return $this->json($response);
    }

    #[Route("/api/deck/draw/{number}", name: "api_card_draw_many", methods: ['POST', "GET"])]
    //Route to draw multiple cards from the deck
    public function draw_cards(SessionInterface $session, $number): Response
    {
        $deck = $session->get("deck");

        $cards = [];
        for ($i = 1; $i <= $number; $i++) {
            $card = $deck->draw_card();
            $cards[] = $card;
        }

        $response = [
            'cards' => $cards,
            'cards_left' => $deck->count(),
        ];

        return $this->json($response);
    }
}
