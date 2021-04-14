<?php
/**
 * Yatzy game functions
 */

declare(strict_types=1);


namespace Ampheris\YatzyFunctions;

use Ampheris\Dice\DiceHand;

/**
 * Functions.
 * @param string $command
 */
function yatzyCommandCheck(string $command) {
    /** @var DiceHand $player */
    $player = unserialize($_SESSION['yatzy']['user']);

    switch ($command){
        case 'throw':
            yatzyThrowDices($player);
            break;
    }

    $_SESSION['yatzy']['user'] = serialize($player);
}

/**
 * @param DiceHand $player
 */
function yatzyThrowDices(DiceHand $player) {
    $player->rollAllDices();
    $_SESSION['yatzy']['dicesThrown'] = true;
    $_SESSION['yatzy']['turns'] -= 1;
    $_SESSION['yatzy']['diceValues'] = $player->getAllLatestValues();
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