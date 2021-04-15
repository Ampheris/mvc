<?php
namespace Ampheris\Dice;

use function Ampheris\Functions\generateHTML;
use function Mos\Functions\url;

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

// Session values
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

/**
 * @param DiceHand $user
 */
$user = unserialize($_SESSION['game']['user']);

?>

<h1>Dice 21 Game, round <?= $_SESSION['game']['gameRounds']; ?></h1>
<?php if ($_SESSION['game']['isInitiated'] == false) { ?>
    <h2>Choose 1 or 2 dices</h2>
    <button class="num-dices" value="1">One dice</button>
    <button class="num-dices" value="2">Two dices</button>
<?php } ?>

<?php if ($_SESSION['game']['winner'] == 'None') { ?>
    <h2>Throw your dice/dices!</h2>
    <?php if ($_SESSION['game']['diceThrown'] == true) { ?>
        <p>Dice(s) thrown:</p>
        <p>
            <?= generateHTML($user); ?>
        </p>
    <?php } ?>
    <p>Your current score: <?= $_SESSION['game']['userScore'] ?></p>
    <button id="throw-dices">Throw dice/dices</button>
    <button id="stop">Stop</button>
<?php } ?>

<?php if ($_SESSION['game']['winner'] != 'None') { ?>
    <h2>Game completed!</h2>
    <p>Your score: <?= $_SESSION['game']['userScore'] ?></p>
    <p>Computers score: <?= $_SESSION['game']['computerScore'] ?></p>
    <?php if ($_SESSION['game']['winner'] == 'User') { ?>
        <p>Congratulations, you have won the round!</p>
    <?php } elseif ($_SESSION['game']['winner'] == 'Computer') { ?>
        <p>Sorry, the computer have won the round!</p>
    <?php } elseif ($_SESSION['game']['winner'] == 'NoWinner') { ?>
        <p>Sorry, no one has won the round!</p>
    <?php } ?>
    <button id="restart">Restart</button>
<?php } ?>


<script type="text/javascript">
    $('.num-dices').click(function () {
        const num = $(this).val();

        $.ajax({
            type: 'POST',
            url: '<?= url("/diceGame/updateSession") ?>',
            data: {'command': 'setDices', 'number': parseInt(num)},
            success: function (){
                location.reload();
            }
        });
    });

    $('#throw-dices').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/diceGame/updateSession") ?>',
            data: {'command': 'throw'},
            success: function (){
                location.reload();
            }
        });
    });

    $('#stop').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/diceGame/updateSession") ?>',
            data: {'command': 'stop'},
            success: function (){
                location.reload();
            }
        });
    });

    $('#restart').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/diceGame/updateSession") ?>',
            data: {'command': 'restart'},
            success: function (){
                location.reload();
            }
        });
    });
</script>