<?php
include 'utils/header.php';

$answers = $_SESSION['answers'];
$questionIndex = $_SESSION['questionIndex'];
$points = 0;
$totalPoints = 0;

for ($i = 0; $i < count($questionIndex); $i++) {
    $correctAnswers = getAnswers($questionIndex[$i], $dbConn);
    foreach($answers as $answer) {
        if (in_array($answer, $correctAnswers)) {
            $points++;
        }
    }
    $totalPoints += count($correctAnswers);
}

$message = getMessage($points, $totalPoints);
?>

<main>

<h1><? echo($message) ?></h1>
<p>You got <? echo($points) ?> out of <? echo($totalPoints) ?> questions correct</p>
    
</main>

<?php
include 'utils/footer.php';
?>