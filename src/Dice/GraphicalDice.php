<?php

namespace Ampheris\Dice;


class GraphicalDice extends Dice
{
    public function __construct() {
        parent::__construct();
    }

    public function graphicDice()
    {
        return "dice-" . $this->lastestThrow();
    }
}