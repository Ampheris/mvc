<?php
/**
 * Yatzy game functions
 */

declare(strict_types=1);


namespace Ampheris\YatzyFunctions;

use Ampheris\Dice\DiceHand;
use function Ampheris\Functions\resetGame;
use function Ampheris\Functions\throwYourDices;

/**
 * Functions.
 * @param string $command
 */
function yatzyCommandCheck(string $command)
{
    /** @var DiceHand $player */
    $player = unserialize($_SESSION['yatzy']['user']);

    switch ($command) {
        case 'throw':
            yatzyThrowDices($player);
            break;
        case 'savePrintReload':
            saveAndReroll($player);
            break;
        case 'nextTurn':
            nextTurn();
            $player = new DiceHand();
            $player->initDices(5);
            $player->rollAllDices();
            break;
        case 'restart':
            restart($player);
            break;
    }

    $_SESSION['yatzy']['user'] = serialize($player);
}

/**
 * @param DiceHand $player
 */
function yatzyThrowDices(DiceHand $player)
{
    $player->rollAllDices();
    $_SESSION['yatzy']['dicesThrown'] = true;
    $_SESSION['yatzy']['diceValues'] = $player->getAllLatestValues();

    $_SESSION['yatzy']['turns'] -= 1;

    foreach ($player->listOfDices as $key => $dice) {
        if ($dice->lastestThrow() == $_SESSION['yatzy']['level']) {
            array_push($_SESSION['yatzy']['storedValues'], $dice);
            unset($player->listOfDices[$key]);
        }
    }
}

/**
 * @param DiceHand $user
 * @return string
 */
function yatzyGenerateHTML(DiceHand $user): string
{
    $arrList = $user->getGraphicDices();
    $result = '';

    foreach ($arrList as $dice) {

        $result .= '<i class="dice-sprite ' . $dice . '"></i>';
    }
    return $result;
}

/**
 * @param DiceHand $player
 */
function saveAndReroll(DiceHand $player)
{
    $_SESSION['yatzy']['turns'] -= 1;

    foreach ($player->listOfDices as $key => $dice) {
        if ($dice->lastestThrow() == $_SESSION['yatzy']['level']) {
            array_push($_SESSION['yatzy']['storedValues'], $dice);
            unset($player->listOfDices[$key]);
        }
    }

    $player->rollAllDices();
}

/**
 * @param DiceHand $player
 * @return string
 */
function printSavedDices(DiceHand $player): string
{
    $storedValues = $_SESSION['yatzy']['storedValues'];

    $arrList = $player->getSavedGraphicDices($_SESSION['yatzy']['level'], $storedValues);
    $result = '';

    foreach ($arrList as $dice) {
        $result .= '<i class="dice-sprite ' . $dice . '"></i>';
    }

    if ($result == ''){
        $result = '<p>No saved dices</p>';
    }

    return $result;
}


function nextTurn()
{
    $level = $_SESSION['yatzy']['level'];
    $amountOfDices = count($_SESSION['yatzy']['storedValues']);

    $_SESSION['yatzy']['turns'] = 3;
    $_SESSION['yatzy']['level'] += 1;
    $_SESSION['yatzy']['userScore'] += $level * $amountOfDices;

    $_SESSION['yatzy']['diceValues'] = [];
    $_SESSION['yatzy']['storedValues'] = [];
}

/**
 * @param DiceHand $player
 */
function restart(DiceHand $player){
    $_SESSION['yatzy']['turns'] = 3;
    $_SESSION['yatzy']['level'] = 1;
    $_SESSION['yatzy']['userScore'] = 0;

    $_SESSION['yatzy']['diceValues'] = [];
    $_SESSION['yatzy']['storedValues'] = [];

    $player = new DiceHand();
    $player->initDices(5);

    yatzyThrowDices($player);
}