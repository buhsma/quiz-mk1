<?php
// ALL posts are handeled here including the last question and the back button


// post from index
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // prettyPrint($_POST);
    if($_POST["hiddenField"] == 'quizSetup') {
        $questionIds = quizSetup($_POST["topic"],$_POST["questionCount"], $dbConn);
        $_SESSION['questionIds'] = $questionIds;
        $_SESSION['questionCounter'] = 0;
        $questionCounter = 0;
        $questionId = $questionIds[0];
        $_SESSION['answers'] = [];
    }
    else {
        
// question & backbtn posts  
        $_SESSION['questionCounter'] += 1;
        $questionCounter = $_SESSION['questionCounter'];
        $questionIds = $_SESSION['questionIds'];

// backbtn post
        if ($_POST["hiddenField"] == 'back') {
            if($_SESSION['questionCounter'] < 2) {
                $_SESSION['questionCounter'] = 0;
                header('Location: index.php');
            }
    
            else {
                $_SESSION['questionCounter'] -= 2;
                array_pop($_SESSION['answers']);
                $questionCounter = $_SESSION['questionCounter'];
            }
        }
        //not $_POST["hiddenField"] == quizSetup or back
        else {
            array_push($_SESSION['answers'], $_POST['hiddenField']);
            // prettyPrint($_SESSION['answers']);
            // prettyPrint($_POST);
            if (count($questionIds) == $questionCounter) {
                header('Location: report.php');
                exit();
        }
        }
    }
//question post
    
    $questionId = $questionIds[$questionCounter];
    $questionData = getQuestion($questionId, $dbConn);
    $question = $questionData['question'];
    $answers = $questionData['answers'];
    shuffle($answers);
    $inputType = $questionData['inputType'];

    $instructions = instructions($inputType);
    
    
}
?>