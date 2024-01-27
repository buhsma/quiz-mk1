<?php
ob_start();
include 'utils/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST["hiddenField"] == 'quizSetup') {
        $questionsIndex = quizSetup($_POST["topic"],$_POST["questionCount"], $dbConn);
        $_SESSION['questionIndex'] = $questionsIndex;
        $_SESSION['questionCounter'] = 0;
        $questionCounter = 0;
        $questionId = $questionsIndex[0];
        $_SESSION['answers'] = [];
    }
    else {
        // prettyPrint($_POST);
        array_push($_SESSION['answers'], $_POST['hiddenField']);
        $_SESSION['questionCounter'] += 1;
        $questionCounter = $_SESSION['questionCounter'];
        $questionsIndex = $_SESSION['questionIndex'];
        if (count($questionsIndex) == $questionCounter) {
            ob_clean();
            header('Location: report.php');
            exit();
        }
        $questionId = $questionsIndex[$questionCounter];
    }

    $questionData = getQuestion($questionId, $dbConn);
    $question = $questionData['question'];
    $answers = $questionData['answers'];
    shuffle($answers);
    $inputType = $questionData['inputType'];
    // prettyPrint($questionData);
    // prettyPrint($inputType);
    // prettyPrint($_SESSION['answers']);
}
?>

<main>

    <h1>QUESTION <? echo($questionCounter); ?></h1>
    <p><? echo($question); ?></p>
    <form class="form" action="question.php" method="POST">
        <label class="form__label" for=""></label>
        <?php foreach($answers as $answer): ?>
            <button type="button" class="<? echo($inputType . ' form__btn--answer'); ?>" name="answer" value="<?php echo $answer; ?>"><? echo($answer); ?></button>
        <?php endforeach; ?>
        <input type="hidden" id="selectedAnswers" name="hiddenField" value="">
        <button class="form__btn" type="submit">SELECT</button>
    </form>
    
</main>

<?php
echo('<script>
document.addEventListener("DOMContentLoaded", function() {
    let buttons = document.querySelectorAll(\'.form__btn--answer\');
    let selectedAnswersInput = document.getElementById(\'selectedAnswers\');
    
    buttons.forEach(function(button) {
        if (button.classList.contains(\'radio\')) {
            button.addEventListener(\'click\', function() {
                buttons.forEach(function(btn) {
                    btn.classList.remove(\'selected\');
                });
                this.classList.add(\'selected\');
                
                // Update the hidden input field with the value attribute of the selected button
                selectedAnswersInput.value = this.value;
            });
        } else if (button.classList.contains(\'checkbox\')) {
            button.addEventListener(\'click\', function() {
                if (this.classList.contains(\'selected\')) {
                    this.classList.remove(\'selected\');
                } else {
                    this.classList.add(\'selected\');
                }
                let selectedAnswers = [];
                buttons.forEach(function(btn) {
                    if (btn.classList.contains(\'selected\')) {
                        selectedAnswers.push(btn.value);
                    }
                });
                selectedAnswersInput.value = selectedAnswers.join(\',\');
            });
        }
    });
});
</script>');
?>


<?php
include 'utils/footer.php';
?>

