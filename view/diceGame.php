<?php
namespace Ampheris\Dice;

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
        'gameRounds' => 0
    ];
?>

<h1>Dice 21 Game</h1>
<?php var_dump($_SESSION['game']); ?>

<?php if ($_SESSION['game']['isInitiated'] == false) { ?>
    <h2>Choose 1 or 2 dices</h2>
    <button class="num-dices" value="1">One dice</button>
    <button class="num-dices" value="2">Two dices</button>
<?php } ?>

<h2>Throw your dice/dices!</h2>
<p>Your current score: <?= $_SESSION['game']['userScore'] ?></p>
<button id="throw-dices">Throw dice/dices</button>
<button id="stop">Stop</button>


<script type="text/javascript">
    $('.num-dices').click(function () {
        const num = $(this).val();

        $.ajax({
            type: 'POST',
            url: '<?= url("/updateSession") ?>',
            data: {'command': 'setDices', 'number': parseInt(num)}
        });
    });

    $('#throw-dices').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/updateSession") ?>',
            data: {'command': 'throw'}
        });
    });

    $('#stop').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/updateSession") ?>',
            data: {'command': 'stop'}
        });
    });
</script>