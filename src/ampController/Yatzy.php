<?php
declare(strict_types=1);

namespace Ampheris\ampController;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use function Ampheris\YatzyFunctions\{yatzyCommandCheck};
use function Mos\Functions\{renderView, url};

class Yatzy
{

    public function index(): ResponseInterface
    {
        $body = renderView("layout/yatzy.php");

        $psr17Factory = new Psr17Factory();

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }


    public function updateYatzy(): ResponseInterface
    {
        yatzyCommandCheck($_POST['command']);

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }
}