<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\url;

?><!doctype html>
<html>
<meta charset="utf-8">
<title><?= $title ?? "No title" ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?= url("/favicon.ico") ?>">
<link rel="stylesheet" type="text/css" href="<?= url("/css/style.css") ?>">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</html>

<body>

<header>
    <nav>
        <a href="<?= url("/") ?>">Home</a> |
        <a href="<?= url("/session") ?>">Session</a> |
        <a href="<?= url("/debug") ?>">Debug</a> |
        <a href="<?= url("/twig") ?>">Twig view</a> |
        <a href="<?= url("/diceGame") ?>">Dice 21</a> |
        <a href="<?= url("/yatzy") ?>">Yatzy</a> |
        <a href="<?= url("/no/such/path") ?>">Show 404 example</a>
    </nav>
</header>
<main>
