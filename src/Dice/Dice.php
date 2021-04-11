<?php


namespace Ampheris\Dice;


class Dice
{
    public int $diceSides;
    public int $lastestThrowValue;

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

    public function changeDiceSides(int $newSides)
    {
        $this->diceSides = $newSides;
    }
}