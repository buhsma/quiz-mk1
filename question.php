<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    // Start the session
    session_start();
}

include 'utils/db.php';
include 'utils/tools.php';
include 'utils/post-all.php';
include 'utils/header.php';

?>

<!--
<===============================================================================================================================>
<\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\HTML/////////////////////////////////////////////////////////////////>
<===============================================================================================================================>
-->

<!-- backbtn -->
<form class="backForm" action="question.php" method="POST">
    <input type="hidden" name="hiddenField" value="back">
    <button class="backBTN" type="submit">&larr;</button>
</form>

<!-- questions and answers -->
<main>

    <h1>QUESTION <? echo($questionCounter +1); ?></h1>
    <p><? echo($question); ?></p>
    <form class="form" id="form" action="question.php" method="POST">
        <input type="hidden" id="selectedAnswers" name="hiddenField" value="as">
        <?php foreach($answers as $answer): ?>
            <button type="button" class="<? echo($inputType . ' form__btn form__btn--answer'); ?>" name="answer" value="<?php echo $answer; ?>"><? echo($answer); ?></button>
        <?php endforeach; ?>
        <p class="form__instructions"><? echo($instructions); ?></p>
        <button class="form__btn" id="submitBtn" type="submit">SELECT</button>
    </form>
    
</main>



<!--
<===============================================================================================================================>
<\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\HTML/////////////////////////////////////////////////////////////////>
<===============================================================================================================================>
-->

<!--
This script includes JavaScript code that enhances the interactivity of radio and checkbox buttons.
It ensures that only one radio button can be selected at a time and handles multiple selections for checkboxes.
Additionally, it assigns the selected answer(s) to the 'value' attribute. -->
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

