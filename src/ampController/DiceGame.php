<?php

declare(strict_types=1);

namespace Ampheris\ampController;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\{
    renderView,
    url
};

use function Ampheris\Functions\{
    commandCheck
};

/**
 * Controller for the dice game routes.
 */
class DiceGame
{
    public function index(): ResponseInterface
    {
        $body = renderView("layout/diceGame.php");

        $psr17Factory = new Psr17Factory();

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }


    public function updateSession(): ResponseInterface
    {
        commandCheck($_POST['command']);

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/diceGame"));
    }
}
