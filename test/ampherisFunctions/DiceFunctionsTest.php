<?php


namespace Ampheris\ampherisFunctions;

use Ampheris\Dice\DiceHand;
use PHPUnit\Framework\TestCase;

use function Ampheris\Functions\{commandCheck, generateHTML};
use function Mos\Functions\destroySession;

/**
 * Test cases for the functions in src/diceFunctions.php.
 */
class DiceFunctionsTest extends TestCase
{
    /**
     * Init function for the dice game.
     */
    public function initSession(){
        $userInit = new DiceHand();
        $computer = new DiceHand();
        $_SESSION['game'] = $_SESSION['game'] ?? [
                'isInitiated' => false,
                'user' => serialize($userInit),
                'userScore' => 0,
                'winner' => 'None',
                'computer' => serialize($computer),
                'computerScore' => 0,
                'gameRounds' => 0,
                'diceThrown' => false
            ];

        $_POST['number'] = 3;
        commandCheck('setDices');
    }

    /**
     * Test the function updateUserDices()
     * @runInSeparateProcess
     */
    public function testUpdateUserDices()
    {
        session_start();
        $this->initSession();

        $expected = true;
        $actual = $_SESSION['game']['isInitiated'];
        $this->assertEquals($expected, $actual);

        destroySession();
    }

    /**
     * Test the function throwYourDices()
     * @runInSeparateProcess
     */
    public function testThrowYourDices()
    {
        session_start();
        $this->initSession();

        $expected = true;

        commandCheck('throw');

        $actual = $_SESSION['game']['diceThrown'];
        $this->assertEquals($expected, $actual);

        $expected = 0;
        $actual = $_SESSION['game']['userScore'];
        $this->assertGreaterThan($expected, $actual);


        destroySession();
    }

    /**
     * Test the function generateHTML()
     * @runInSeparateProcess
     */
    public function testGenerateHTML()
    {
        session_start();
        $this->initSession();

        commandCheck('throw');

        $user = unserialize($_SESSION['game']['user']);
        $actual = generateHTML($user);

        $this->assertNotEmpty($actual);

        destroySession();
    }

    /**
     * Test the function checkScore()
     * Will not be 100% due to the fact that i cant know who the winner will be,
     * so will only check if the winner is not None and not if the winner can be
     * set to computer, player and NoWinner.
     * @runInSeparateProcess
     */
    public function testCheckScore()
    {
        session_start();
        $this->initSession();

        commandCheck('throw');
        commandCheck('stop');

        $actual = $_SESSION['game']['winner'];

        $this->assertNotEquals('None', $actual);

        destroySession();
    }

    /**
     * Test the function computersTurn()
     * @runInSeparateProcess
     */
    public function testComputersTurn()
    {
        session_start();
        $this->initSession();

        commandCheck('throw');
        commandCheck('stop');

        $actual = $_SESSION['game']['computerScore'];

        $this->assertGreaterThan(0, $actual);

        destroySession();
    }
}