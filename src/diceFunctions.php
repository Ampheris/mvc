<?php

declare(strict_types=1);

namespace Ampheris\Functions;

use Ampheris\Dice\DiceHand;

/**
 * Functions.
 * @param string $command
 */
function commandCheck(string $command)
{

    /** @var DiceHand $user */
    $user = unserialize($_SESSION['game']['user']);

    /** @var DiceHand $computer */
    $computer = unserialize($_SESSION['game']['computer']);

    switch ($command) {
        case 'setDices':
            $number = intval($_POST['number']);
            updateUserDices($number, $user);
            break;
        case 'throw':
            throwYourDices($user);
            break;
        case 'stop':
            computersTurn($computer);
            checkScore();
            break;
        case 'restart':
            resetGame();
            $user = new DiceHand();
            $computer = new DiceHand();
            break;
    }

    $_SESSION['game']['user'] = serialize($user);
    $_SESSION['game']['computer'] = serialize($computer);
}

/**
 * @param int $number
 * @param DiceHand $user
 */
function updateUserDices(int $number, DiceHand $user)
{
    $_SESSION['game']['isInitiated'] = true;
    $user->initDices(intval($number));
}

/**
 * @param DiceHand $user
 */
function throwYourDices(DiceHand $user)
{
    $_SESSION['game']['diceThrown'] = true;
    $user->rollAllDices();
    $_SESSION['game']['userScore'] += $user->getAllRolledValues();
}

/**
 * @param DiceHand $user
 */

function generateHTML(DiceHand $user): string
{
    $arrList = $user->getGraphicDices();
    $result = '';

    foreach ($arrList as $dice) {
        $result .= '<i class="dice-sprite ' . $dice . '"></i>';
    }
    return $result;
}

function checkScore()
{
    $userScore = $_SESSION['game']['userScore'];
    $computerScore = $_SESSION['game']['computerScore'];

    if ($userScore == 21 or ($userScore < 21 and $computerScore > 21)) {
        $_SESSION['game']['winner'] = 'User';
    }

    // If computer has score 21 it wins, even if user got 21 in score.
    if ($computerScore == 21) {
        $_SESSION['game']['winner'] = 'Computer';
    }

    if ($computerScore > 21 and $userScore > 21) {
        $_SESSION['game']['winner'] = 'NoWinner';
    }
}

function resetGame()
{
    $_SESSION['game']['gameRounds'] += 1;
    $_SESSION['game']['userScore'] = 0;
    $_SESSION['game']['computerScore'] = 0;
    $_SESSION['game']['isInitiated'] = false;
    $_SESSION['game']['winner'] = 'None';
    $_SESSION['game']['diceThrown'] = false;
}

/**
 * @param DiceHand $computer
 */
function computersTurn(DiceHand $computer)
{

    //Init computer with 1 dice
    $computer->initDices(1);

    // Run while computer is not stopped.
    while (true) {
        $computerScore = $_SESSION['game']['computerScore'];

        if ($computerScore < 21) {
            $computer->rollAllDices();
            $_SESSION['game']['computerScore'] += $computer->getAllRolledValues();
        }

        if ($computerScore > 21 or $computerScore == 21) {
            break;
        }
    }
}