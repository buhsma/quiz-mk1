<?php

if (session_status() == PHP_SESSION_NONE) {
    // Start the session
    session_start();}

// initiate variables
$answers = $_SESSION['answers'];
$questionIds = $_SESSION['questionIds'];
$points = 0;
$totalPoints = 0;

include 'utils/db.php';
include 'utils/tools.php';
include 'utils/post-all.php';
include 'utils/header.php';

//check if answers are correct
for ($i = 0; $i < count($questionIds); $i++) {
    $correctAnswers = getAnswers($questionIds[$i], $dbConn);
    foreach($answers as $answer) {
        if (in_array($answer, $correctAnswers)) {
            $points++;
        }
    }
    $totalPoints += count($correctAnswers);
}
//get message coresponding to performance
$message = getMessage($points, $totalPoints);

?>

<!--
<===============================================================================================================================>
<\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\HTML/////////////////////////////////////////////////////////////////>
<===============================================================================================================================>
-->

<main>

<h1><? echo($message) ?></h1>
<p>You got <? echo($points) ?> out of <? echo($totalPoints) ?> total points from <? echo(count($questionIds)) ?> questions</p>
<form class="form" action="index.php">
    <button class="form__btn">RESTART</button>
</form>
</main>

<!--
<===============================================================================================================================>
<\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\HTML/////////////////////////////////////////////////////////////////>
<===============================================================================================================================>
-->

<?php
include 'utils/footer.php';

//reset for restart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_destroy();
}
?>