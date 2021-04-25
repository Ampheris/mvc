<?php


namespace Ampheris\Dice;


class Dice
{
    public $diceSides;
    public $lastestThrowValue;

    function __construct()
    {
        $this->diceSides = 6;
        $this->lastestThrowValue = 0;
    }

    public function throwDice()
    {
        $this->lastestThrowValue = rand(1, $this->diceSides);
    }

    public function lastestThrow(): int
    {
        return $this->lastestThrowValue;
    }
}