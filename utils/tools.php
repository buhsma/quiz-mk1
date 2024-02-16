<?php
    // prettyPrint function to output variables in a readable format
    function prettyPrint($var) {
        echo '<pre>';
            print_r($var);
        echo '</pre>';
    }

// returns an array with all topics
function getTopics($dbConn) {
    $query = $dbConn->query("SELECT DISTINCT topic FROM questions");
    $topics = $query->fetchAll(PDO::FETCH_COLUMN);
    // prettyPrint($topics);
        return $topics;
    
}

//generates an array of random question IDs with a length chosen by the user
    function quizSetup($topic, $count, $dbConn) {
        $query = $dbConn->prepare("SELECT id FROM questions WHERE topic = ?");
        $query->bindParam(1, $topic);
        $query->execute();
        $allQuestionsIds = $query->fetchAll(PDO::FETCH_COLUMN);
        shuffle($allQuestionsIds);
        $questionsIndex = array_slice($allQuestionsIds, 0, $count);
        return $questionsIndex;
    }
// return current question and answers
    function getQuestion($id, $dbConn) {
        $query = $dbConn->prepare("SELECT * FROM questions WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $questionData = $query->fetch(PDO::FETCH_ASSOC);
        $question = $questionData['question_text'];
        $answers = [];
        foreach (range(1, 5) as $index) {
            $answerKey = "answer_$index";
            if (isset($questionData[$answerKey]) && $questionData[$answerKey] !== "") {
                $answers[] = $questionData[$answerKey];
            }
        }
        $inputType = 'radio';
        if (strlen($questionData['correct']) > 1) {
            $inputType = 'checkbox';
        } 
        
        return [
            'question' => $question,
            'answers' => $answers,
            'inputType' => $inputType,
        ];
    }

// get answer by ID and return the correct answers
    function getAnswers($id, $dbConn) {
        $query = $dbConn->prepare("SELECT * FROM questions WHERE id = :id");
        $query->execute(array(':id' => $id));
        $questionData = $query->fetch(PDO::FETCH_ASSOC);
        $correctAnswerIndex = extractIntegers($questionData['correct']);
        foreach($correctAnswerIndex as $i) {
            $correctAnswer = $questionData['answer_'.$i];
            $correctAnswers[] = $correctAnswer;
        }
        return $correctAnswers;
    }

//regex zeugs. danke GPT
    function extractIntegers($string) {
        preg_match_all('/\d+/', $string, $matches);
        return $matches[0];
    }

// get message coresponding to % of correct answers
    function getMessage($points, $totalPoints) {
        $messages = [
            "My disappointment is immeasurable and my day is ruined.",
            "Bad performance. Let's work on it.",
            "Oh no, that didn't go well. Keep practicing.",
            "Hmm, you might want to try again.",
            "Not bad, but there's room for improvement.",
            "Good effort! You're doing well.",
            "Great work! Keep it up.",
            "Amazing job! You did exceptionally well.",
            "Incredible! You're on fire!",
            "God-like performance! You are absolutely phenomenal!",
            "It’s over 9000!",
        ];
        $messageIndexPrecentage = ($points / $totalPoints) *10;
        $messageIndex = intval($messageIndexPrecentage);
        return $messages[$messageIndex];
    }

    function instructions($inputType) {
        $instructions = "Choose <strong>ALL</strong> the correct options from the list provided.";
        if ($inputType === 'radio') {
        $instructions = "Select <strong>THE</strong> correct option from the choices provided.";
    }
    return $instructions;
}
?>
