<?php
declare(strict_types=1);


namespace Ampheris\ampController;


use PHPUnit\Framework\TestCase;

class AmpControllerYatzyViewTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new Yatzy();
        $this->assertInstanceOf("\Ampheris\ampController\Yatzy", $controller);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerReturnsResponse()
    {
        $controller = new Yatzy();

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
        $controller = new Yatzy();
        $_POST['command'] = 'restart';

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->updateYatzy();
        $this->assertInstanceOf($exp, $res);
    }
}