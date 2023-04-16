<?php

namespace App\Controller;

use App\Dice\DiceGraphic;
use App\Dice\DiceHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DiceGameController extends AbstractController
{
    #[Route("/game/pig", name: "pig_start")]
    public function home(): Response
    {
        return $this->render('game.html.twig');
    }

    #[Route("/game/pig/test/roll", name: "test_roll_dice")]
    public function testRollDice(): Response
    {
        $die = new Dice();

        $data = [
            "dice" => $die->roll(),
            "diceString" => $die->getAsString(),
        ];

        return $this->render('pig/roll.html.twig', $data);
    }

    #[Route("/game/pig/test/roll/{num<\d+>}", name: "test_roll_num_dices")]
    public function testRollDices(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $diceRoll = [];
        for ($i = 1; $i <= $num; $i++) {
            #$die = new Dice();
            $die = new DiceGraphic();
            $die->roll();
            #Rullar och skapar tärningar
            #Hämtar tärningens representation
            $diceRoll[] = $die->getAsString();
        }

        $data = [
            #Skickar ner till vyn för att sedan renderas och visas upp på sidan
            "num_dices" => count($diceRoll),
            "diceRoll" => $diceRoll,
        ];

        return $this->render('pig/roll_many.html.twig', $data);
    }

    #[Route("/game/pig/test/dicehand/{num<\d+>}", name: "test_dicehand")]
    public function testDiceHand(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 dices!");
        }

        $hand = new DiceHand();
        for ($i = 1; $i <= $num; $i++) {
            $hand->add(new DiceGraphic());
        }

        $hand->roll();

        $data = [
            "num_dices" => $hand->getNumberDices(),
            "diceRoll" => $hand->getString(),
        ];

        return $this->render('pig/dicehand.html.twig', $data);
    }

    #[Route("/game/pig/init", name: "pig_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('pig/init.html.twig');
    }

    #[Route("/game/pig/init", name: "pig_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        //Antal tärningar som är valda i init.html.twig
        $numDice = $request->request->get('num_dices');

        $hand = new DiceHand();
        for ($i = 1; $i <= $numDice; $i++) {
            $hand->add(new DiceGraphic());
        }
        $hand->roll();

        $session->set("pig_dicehand", $hand);
        //Sparar ner olika värden i sessioner
        $session->set("pig_dices", $numDice);
        //Sätter värden i mina sessionvariabler.
        $session->set("pig_round", 0);
        $session->set("pig_total", 0);

        return $this->redirectToRoute('pig_play');
    }

    #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response
    {
        $dicehand = $session->get("pig_dicehand");

        $data = [
            "rollUrl" => $this->generateUrl("pig_roll"),
            "saveUrl" => $this->generateUrl("pig_save"),
            "restartUrl" => $this->generateUrl("pig_init_get"),
            "pigDices" => $session->get("pig_dices"),
            "pigRound" => $session->get("pig_round"),
            "pigTotal" => $session->get("pig_total"),
            "diceValues" => $dicehand->getString() 
        ];

        return $this->render('pig/play.html.twig', $data);
    }

    #[Route("/game/pig/roll", name: "pig_roll", methods: ['POST'])]
    public function roll(
        SessionInterface $session
    ): Response
    {    
        //Hämtar handen från sessionen
        $dicehand = $session->get("pig_dicehand");
        //Kör roll metoden för nuvarande handen
        $dicehand->roll();

        
        $roundTotal = $session->get("pig_round");
        $round = 0;
        //Lägger till summan av alla tärningar i "Round"
        $values = $dicehand->getValues();
        foreach ($values as $value) {
            $round += $value;
        }
        $this->addFlash(
            'notice',
            'Your rerolled the current hand!'
        );
        $session->set("pig_round", $roundTotal + $round);
        return $this->redirectToRoute('pig_play');
    }

    #[Route("/game/pig/save", name: "pig_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response
    {   
        $roundTotal = $session->get("pig_round");
        $gameTotal = $session->get("pig_total");

        //Sätter nuvarande pig_round till 0
        $session->set("pig_round", 0);
        //Uppdaterar Total med nuvarande summan från round
        $session->set("pig_total", $roundTotal + $gameTotal);
        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );
        return $this->redirectToRoute('pig_play');
    }
}