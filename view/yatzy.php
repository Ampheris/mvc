<?php
namespace Ampheris\Dice;

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
        'diceValues' => []
    ];

/**
 * @param DiceHand $user
 */
$user = unserialize($_SESSION['yatzy']['user']);

?>

<h1>Yatzy Game</h1>
<?php var_dump($_SESSION['yatzy']);?>

<?php if ($_SESSION['yatzy']['level'] <= 6) {?>
    <p>Throw your dices and then choose how many dices you want to save.</p>
    <button id="throw-dices">Throw dices</button>
    <?php if ($_SESSION['yatzy']['dicesThrown'] == true) { ?>
        <p>Dice(s) thrown:</p>
        <p>
            <?= yatzyGenerateHTML($user); ?>
        </p>
  <?php }?>
    <p>Which do you want to keep?</p>
<?php } else {?>
    <h2>Game completed</h2>
    <p>Your score: <?= $_SESSION['yatzy']['userScore'] ?></p>
<?php }?>


<script type="text/javascript">

    $('#throw-dices').click(() => {
        $.ajax({
            type: 'POST',
            url: '<?= url("/yatzy/updateYatzy") ?>',
            data: {'command': 'throw'},
            success: function (){
                location.reload();
            },
            error: function () {
                console.log("Error!");
            }
        });
    });
</script>