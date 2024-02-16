<?php
$title = 'Quiz';
if (session_status() == PHP_SESSION_NONE) {
    // Start the session
    session_start();}
include 'utils/db.php';
include 'utils/tools.php';
include 'utils/header.php';

//get all topics to show in dropdown
$topics = getTopics($dbConn);

?>

<!--
<===============================================================================================================================>
<\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\HTML/////////////////////////////////////////////////////////////////>
<===============================================================================================================================>
-->

<main>
    <h1>TRIVIA QUIZ</h1>
    <p>Explore your interests with our quiz platform! Choose any topic and set the number of questions to match your preference. 
        Dive into a quick, personalized, and engaging quiz experience today!</p>
<!-- setup form. choice topic and question count -->
    <form class="form" action="question.php" method="post">
        <div class="form__dropdownContainer">
            <label class="form__dropdownContainer__label" for="dropdown">Choose an topic:</label>
            <select class="form__dropdownContainer__dropdown" id="dropdown" name="topic">
                <!-- loop throu all topics and populate dropdown -->
                <?php foreach($topics as $key => $topic): ?>
                    <option value="<?php echo $topic; ?>"><?php echo ucfirst($topic); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form__numberContainer">
            <label class="form__numberContainer__label" for="questionCount">How many questions?</label>
            <input class="form__numberContainer__input" type="number" name="questionCount" id="questionCount" value="10">
        </div>
        <input type="hidden" name="hiddenField" value="quizSetup">
        <button class="form__btn" type="submit">START</button>
    </form>
</main>

<!--
<===============================================================================================================================>
<\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\HTML/////////////////////////////////////////////////////////////////>
<===============================================================================================================================>
-->

<?php
include 'utils/footer.php';
?>