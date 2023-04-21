<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    //Route som visar min förstasida med alla undersidor
    #[Route("/card", name: "card_init_get", methods: ['GET'])]
    public function init(
        Request $request,
        SessionInterface $session
    ): Response
    {   
        $data = [
            "showdeck" => $this->generateUrl("show_card_deck"),
            "shuffledeck" => $this->generateUrl("shuffle_card_deck"),
            "draw_card" => $this->generateUrl("draw_card"),
        ];
        //Skapar ett nytt Card objekt och sparar i session
        $hand = new Card();
        $session->set('deck_of_cards', $hand);
        if (!$session->has('deck_of_cards')) {
            $hand = new Card();
            $session->set('deck_of_cards', $hand);
        }
        return $this->render('card.html.twig', $data);
    }

    //Route som visar kortleken
    #[Route('/card/deck', name: 'show_card_deck', methods: ['GET'])]
    public function show_deck(
        SessionInterface $session
    ): Response
    {
        //Hämtar den aktuella sessionen
        $current_deck = $session->get('deck_of_cards');
        $data = [
            'init_deck' => $current_deck->get_deck()
        ];
        return $this->render('card/card_deck.html.twig', $data);
    }  
        
    //Route som visar den blandade kortleken
    #[Route('/card/deck/shuffle', name: 'shuffle_card_deck', methods: ['GET'])]
    public function shuffle_deck(
        SessionInterface $session
    ): Response
    {   
        //Skapar ett nytt objekt av klassen DeckOfCards
        $hand = new DeckOfCards();
        $session->set('shuffle', $hand);

        //Hämtar den aktuella sessionen
        $current_deck = $session->get('shuffle');

        //Skickar med data till min vy
        $data = [
            'init_deck' => $current_deck->shuffle_deck()
        ];
        return $this->render('card/card_deck.html.twig', $data);
    } 

    //Route för att dra ut ett kort från kortleken
    #[Route('/card/deck/draw', name: 'draw_card', methods: ['GET'])]
    public function draw_card(
        SessionInterface $session
    ): Response
    {
        //Hämtar ut aktuella kortleken
        $current_deck = $session->get('deck_of_cards');
        
        //Skapar en session där man drar ett kort från kortleken
        $drawn_card = $current_deck->draw_card();
        $session->set('deck_of_cards', $current_deck);
    
        //Skickar med data till min vy
        $data = [
            'draw_card' => $drawn_card,
            'count_cards' => $current_deck->count_deck()
        ];
        return $this->render('card/draw_card.html.twig', $data);
    }     
    
    //Route för att dra ut ett kort från kortleken
    #[Route('/card/deck/draw/{num<\d+>}', name: 'draw_many_card', methods: ['GET'])]
    public function draw_multiple_cards(int $num,
        SessionInterface $session
    ): Response
    {
        $diceRoll = [];
        $die = $session->get('deck_of_cards');
        if ($num > $die->count_deck()) {
            throw new \Exception("Card deck empty");
        }
        for ($i = 1; $i <= $num; $i++) {
            #$die = new Dice();
            $diceRoll[] = $die->draw_card();
        }
        
        $data = [
            'diceRoll' => $diceRoll,
            'count' => $die->count_deck(),
        ];
        return $this->render('card/draw_many.html.twig', $data);
    }
}