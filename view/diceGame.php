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
$_SESSION['game'] = $_SESSION['game'] ?? [
        'isInitiated' => false,
        'user' => serialize(new DiceHand()),
        'userDices' => 0,
        'userScore' => 0,
        'userWin' => false,
        'computer' => serialize(new DiceHand()),
        'computerScore' => 0,
        'stopComputer' => false,
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
<button id="stop">Stop/button>


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
</script>
<?php
//Init computers dices
/*$computer->initDices(1);


// Computer throws dices until computer reaches 21 or more.
    while (!$stopComputer and !$userWin) {
        if ($computerScore < 21 ){
            $computer->rollAllDices();
            $computerScore +=$computer->getAllRolledValues();
        } elseif ($computerScore > 21 ) {
            $stopComputer = true;
        }
    }*/
?>

<p>Result shows here!</p>
