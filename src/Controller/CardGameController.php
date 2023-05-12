<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\DeckOfCardsJoker;
use App\Card\Card;
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
            "drawcard" => $this->generateUrl("card_draw"),
        ];
        return $this->render('card.html.twig', $data);
    }

    #[Route("/card", name: "card_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $deck = new DeckOfCardsJoker();
        $session->set("new_deck", $deck);
        // Redirect to the "card_play" route
        return $this->redirectToRoute('card_play');
    }

    #[Route("/card/deck", name: "card_play", methods: ['GET'])]
    public function play_deck(
        SessionInterface $session
    ): Response
    {
        $current_deck = $session->get("new_deck");
        if ($current_deck !== null) {
            $data = [
                "init_deck" => $current_deck->add_joker()
            ];
            return $this->render('card/card_deck.html.twig', $data);
        } else {
            $deck = new DeckOfCardsJoker();
            $session->set("new_deck", $deck);
            $current_deck = $session->get("new_deck");
            $data = [
                "init_deck" => $current_deck->add_joker()
            ];
        }
        return $this->render('card/card_deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle", methods: ['GET'])]
    public function shuffle(
        SessionInterface $session
    ): Response
    {
        $hand = new DeckOfCards();
        $session->set("shuffle_deck", $hand);
        $shuffle_deck = $session->get("shuffle_deck", $hand);
        $data = [
            "shuffled_deck" => $shuffle_deck->shuffle_deck()
        ];
        return $this->render('card/shuffled_card_deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw", methods: ['GET'])]
    public function draw(
        SessionInterface $session
    ): Response
    {
        $shuffle_deck = $session->get("shuffle_deck");

        $data = [
            "draw_card" => $shuffle_deck->draw_card(),
            "cards_left" => $shuffle_deck->count(),
        ];
        return $this->render('card/draw_card.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "draw_many")]
    public function draw_many(
        SessionInterface $session,
        int $num
      ): Response
    {
        if ($num > 50) {
            throw new \Exception("Can not draw more than 99 cards!");
        }

        $shuffle_deck = $session->get("shuffle_deck");
        $drawn_cards = [];
        for ($i = 1; $i <= $num; $i++) {
            $drawn_cards[] = $shuffle_deck->draw_card();
        }

        $data = [
            "cards" => $drawn_cards,
            "cards_left" => $shuffle_deck->count(),
        ];

        return $this->render('card/many.html.twig', $data);
    }
}
