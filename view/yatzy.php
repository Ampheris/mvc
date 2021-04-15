<?php
namespace Ampheris\Dice;

use function Ampheris\YatzyFunctions\printSavedDices;
use function Ampheris\YatzyFunctions\yatzyGenerateHTML;
use function Mos\Functions\url;

// Session values
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

/**
 * @param DiceHand $user
 */
$user = unserialize($_SESSION['yatzy']['user']);

?>

<h1>Yatzy Game</h1>
<?php if ($_SESSION['yatzy']['level'] <= 6) { ?>
    <p>Throw your dices and then pick dices to save.</p>

    <?php if ($_SESSION['yatzy']['dicesThrown'] == false) { ?>
        <button id="throw-dices">Throw dices and save #<?= $_SESSION['yatzy']['level'] ?> dices</button>
    <?php } ?>

    <?php if ($_SESSION['yatzy']['dicesThrown'] == true) { ?>
        <?php if ($_SESSION['yatzy']['turns'] != 0) { ?>
            <p>Dice(s) thrown:</p>
            <p>
                <?= yatzyGenerateHTML($user); ?>
            </p>
            <p>Click the button below to save the #<?= $_SESSION['yatzy']['level'] ?> dices and reroll.</p>
            <button id="save-dices">Save and throw more dices</button>
        <?php } ?>
        <?php if ($_SESSION['yatzy']['turns'] == 0) { ?>
            <p>Dice(s) saved this level:</p>
            <p>
                <?= printSavedDices($user); ?>
            </p>
            <p>Turns are over, go to next round!</p>
            <button id="next-turn">Next turn</button>
        <?php } else { ?>
            <p>Dice(s) saved for current level:</p>
            <p>
                <?= printSavedDices($user); ?>
            </p>
        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <h2>Game completed</h2>
    <p>Your score: <?= $_SESSION['yatzy']['userScore'] ?> </p>
    <p>Want to restart?</p>
    <button id="restart">Restart</button>
<?php } ?>

<script type="text/javascript">

    $('#throw-dices').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/yatzy/updateYatzy") ?>',
            data: {'command': 'throw'},
            success: function () {
                location.reload();
            },
            error: function () {
                console.log("Error!");
            }
        });
    });

    $('#save-dices').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/yatzy/updateYatzy") ?>',
            data: {'command': 'savePrintReload'},
            success: function () {
                location.reload();
            },
            error: function () {
                console.log("Error!");
            }
        });
    });

    $('#next-turn').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/yatzy/updateYatzy") ?>',
            data: {'command': 'nextTurn'},
            success: function () {
                location.reload();
            },
            error: function () {
                console.log("Error!");
            }
        });
    });

    $('#restart').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/yatzy/updateYatzy") ?>',
            data: {'command': 'restart'},
            success: function () {
                location.reload();
            },
            error: function () {
                console.log("Error!");
            }
        });
    });
</script>