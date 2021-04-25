<?php
declare(strict_types=1);

namespace Ampheris\ampherisFunctions;


use Ampheris\Dice\DiceHand;
use PHPUnit\Framework\TestCase;
use function Ampheris\Functions\commandCheck;
use function Ampheris\YatzyFunctions\printSavedDices;
use function Ampheris\YatzyFunctions\yatzyCommandCheck;
use function Ampheris\YatzyFunctions\yatzyGenerateHTML;
use function Mos\Functions\destroySession;

/**
 * Class yatzyFunctionsTest
 * @package Ampheris\ampherisFunctions
 */
class YatzyFunctionsTest extends TestCase
{
    /**
     * Init function for the dice game.
     */
    public function initSession()
    {
        $userInit = new DiceHand();
        $userInit->initDices(5);

        $_SESSION['yatzy'] = $_SESSION['yatzy'] ?? [
                'user' => serialize($userInit),
                'userScore' => 0,
                'turns' => 3,
                'level' => 1,
                'dicesThrown' => false,
                'dices' => 5,
                'diceValues' => [],
                'storedValues' => []
            ];

        yatzyCommandCheck('throw');
    }

    /**
     * Test the function yatzyThrowDices()
     * @runInSeparateProcess
     */
    public function testYatzyThrowDices()
    {
        session_start();
        $this->initSession();

        $expected = true;
        $actual = $_SESSION['yatzy']['dicesThrown'];
        $this->assertEquals($expected, $actual);

        $expected = 2;
        $actual = $_SESSION['yatzy']['turns'];
        $this->assertEquals($expected, $actual);

        $actual = $_SESSION['yatzy']['diceValues'];
        $this->assertNotEmpty($actual);

        destroySession();
    }

    /**
     * Test the function yatzyGenerateHTML()
     * @runInSeparateProcess
     */
    public function testYatzyGenerateHTML()
    {
        session_start();
        $this->initSession();

        $user = unserialize($_SESSION['yatzy']['user']);
        $actual = yatzyGenerateHTML($user);

        $this->assertNotEmpty($actual);

        destroySession();
    }

    /**
     * Test the function printSavedDices()
     * @runInSeparateProcess
     */
    public function testPrintSavedDices()
    {
        session_start();
        $this->initSession();

        yatzyCommandCheck('savePrintReload');
        yatzyCommandCheck('savePrintReload');

        $user = unserialize($_SESSION['yatzy']['user']);
        $actual = printSavedDices($user);

        $this->assertNotEmpty($actual);

        destroySession();
    }

    /**
     * Test the function saveAndReload()
     * @runInSeparateProcess
     */
    public function testSaveAndReload()
    {
        session_start();
        $this->initSession();

        yatzyCommandCheck('savePrintReload');

        $expected = 1;
        $actual = $_SESSION['yatzy']['turns'];
        $this->assertEquals($expected, $actual);


        destroySession();
    }

    /**
     * Test the function nextTurn()
     * @runInSeparateProcess
     */
    public function testNextTurn()
    {
        session_start();
        $this->initSession();

        yatzyCommandCheck('savePrintReload');
        yatzyCommandCheck('nextTurn');

        $actual = $_SESSION['yatzy']['diceValues'];
        $this->assertEmpty($actual);

        $actual = $_SESSION['yatzy']['storedValues'];
        $this->assertEmpty($actual);

        $expected = 3;
        $actual = $_SESSION['yatzy']['turns'];
        $this->assertEquals($expected,$actual);

        $actual = $_SESSION['yatzy']['level'];
        $this->assertGreaterThan(1, $actual);

        $actual = $_SESSION['yatzy']['userScore'];
        $this->assertGreaterThanOrEqual(0, $actual);

        destroySession();
    }
}