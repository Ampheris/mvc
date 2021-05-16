<?php

declare(strict_types=1);

namespace Ampheris\ampController;


use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Dice view.
 */
class AmpControllerDiceViewTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new DiceGame();
        $this->assertInstanceOf("\Ampheris\ampController\DiceGame", $controller);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerReturnsResponse()
    {
        $controller = new DiceGame();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->index();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns correct response.
     * @runInSeparateProcess
     */
    public function testControllerUpdateReturnsResponse()
    {
        $controller = new DiceGame();
        $_POST['command'] = 'restart';

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->updateSession();
        $this->assertInstanceOf($exp, $res);
    }

}
