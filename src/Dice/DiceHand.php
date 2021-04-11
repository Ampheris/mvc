<?php


namespace Ampheris\Dice;

class DiceHand
{
    public array $listOfDices;

    function __construct()
    {
        $this->listOfDices = [];
    }

    function initDices($numOfDices)
    {
        for ($i = 0; $i < $numOfDices; $i++) {
            array_push($this->listOfDices, new GraphicalDice());
        }
    }

    function rollAllDices()
    {
        foreach ($this->listOfDices as $dice) {
            $dice->throwDice();
        }
    }

    function getAllRolledValues(): int
    {
        $result = 0;

        foreach ($this->listOfDices as $dice) {
            $result += $dice->lastestThrow();
        }

        return $result;
    }

    function getGraphicDices(): array
    {
        $returnArr = [];

        foreach ($this->listOfDices as $dice) {
            array_push($returnArr, $dice->graphicDice());
        }

        return $returnArr;
    }
}