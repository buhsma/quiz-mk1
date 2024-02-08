<?php 
include 'utils/db.php';
include 'utils/tools.php';
function insert($question, $dbConn, $correctT) {
    // foreach ($data as $question) {
        prettyPrint($question);
        $topic = $question[0];
        $questionText = $question[1];
        // $trivia = $question[2];
        $answersT = $question[2];   
        $sql = $dbConn->prepare("INSERT INTO questions_mk3 (`topic`, `question_text`) VALUES (:topic, :questionText)");

        $sql->bindParam(':topic', $topic);
        $sql->bindParam(':questionText', $questionText);
        // $sql->bindParam(':trivia', $trivia);

        $sql->execute();
        

        $questionId = $dbConn->lastInsertId();
            // prettyPrint($answersT);
            // prettyPrint($correctT);
        foreach ($correctT as $daRightOne) {
            $answersT[$daRightOne-1][1] = 1;
            
        }
        foreach ($answersT as $answer) {
            $answerText = $answer[0];
            $isCorrect = $answer[1];

            $sql = $dbConn->prepare("INSERT INTO answers_mk3 (`answers_text`, `is_correct`, `question_id`) 
            VALUES (:answerText, :isCorrect, :questionId)");

            $sql->bindParam(':questionId', $questionId);    
            $sql->bindParam(':answerText', $answerText);
            $sql->bindParam(':isCorrect', $isCorrect);

            $sql->execute();
            

        }   
    // }
};

function getQuestion($dbConn){
    $query = $dbConn->prepare("SELECT * FROM questions");
    $query->execute();
    $question = $query->fetchAll(PDO::FETCH_ASSOC);
    return $question;
}

function getNonEmptyAnswers($questionArray) {
    $nonEmptyAnswers = array();

    // Loop through each answer in the question array
    foreach ($questionArray as $key => $value) {
        // Check if the value is a non-empty string and not one of the excluded fields
        if (!empty($value) && is_string($value) && $key !== 'correct' && $key !== 'question_text' && $key !== 'topic' && $key !== 'id')
 {
            // Add the non-empty answer to the result array
            $nonEmptyAnswers[] = [$value, 0];
        }
    }

    return $nonEmptyAnswers;
}

// $data = [
//     [
//         "SQL",
//         "What does SQL stand for?",
//         "SQL stands for Structured Query Language.",
//         [
//             ["Structured Question Language", 0],
//             ["System Query Language", 0],
//             ["Structured Quiz Language", 0],
//             ["Structured Query Language", 1]
//         ]
//     ],
    



//     ];
    $data = getQuestion($dbConn);
    // prettyPrint($data);
    foreach ($data as $dataT) {
        // prettyPrint($question);
        $questionT = $dataT['question_text'];
        $topicT = $dataT['topic'];
        $correctT = extractIntegers($dataT['correct']);
        $answersT = getNonEmptyAnswers($dataT);
        // prettyPrint($questionT);
        // prettyPrint($topicT);
        // prettyPrint($correctT); 
        // prettyPrint($answersT);
        $thatStuff = [$topicT, $questionT, $answersT];
        prettyPrint($thatStuff);
        insert($thatStuff, $dbConn, $correctT, $answersT);
    }

    
    // prettyPrint($thatStuff);
// insert($data, $dbConn);
?>

