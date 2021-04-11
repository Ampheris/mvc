<?php

declare(strict_types=1);

namespace Ampheris\Functions;

use Ampheris\Dice\DiceHand;

/**
 * Functions.
 * @param string $command
 */
function commandCheck(string $command) {

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
            break;
    }

    $_SESSION['game']['user'] = serialize($user);
    $_SESSION['game']['computer'] = serialize($computer);
}

/**
 * @param $number
 * @param DiceHand $user
 */
function updateUserDices($number, DiceHand $user)
{
    
}

/**
 * @param DiceHand $user
 */
function throwYourDices(DiceHand $user)
{
    $user->rollAllDices();
}

function computersTurn($computer) {
    $computerScore = $_SESSION['game']['computerScore'];
    $stopComputer = $_SESSION['game']['stopComputer'];
    $userWin = $_SESSION['game']['userWin'];

    while (!$userWin and !$stopComputer) {
        if ( $computerScore < 21) {
            $computer->rollAllDices();
            $computerScore += $computer->getAllRolledValues();
        } elseif ($computerScore > 21) {
            $stopComputer = true;
        }
    }
}