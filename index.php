<?php
include 'utils/header.php';

$topics = getTopics($dbConn);
prettyPrint($topics);
?>

<main>
    <h1>TRIVIA QUIZ</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur dolore esse magni culpa nisi id placeat est, 
        tempore eveniet quas libero, nemo odit non nesciunt numquam a modi nostrum veritatis.</p>
    <form action="question.php" method="post">
        <label for="dropdown">Choose an topic:</label>
        <select id="dropdown" name="topic">
            <?php foreach($topics as $key => $topic): ?>
                <option value="<?php echo $topic; ?>"><?php echo ucfirst($topic); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="questionCount">How many questions?</label>
        <input type="number" name="questionCount" id="questionCount">
        <input type="hidden" name="hiddenField" value="quizSetup">
        <button type="submit">START</button>
    </form>
</main>

<?php
include 'utils/footer.php';
?>