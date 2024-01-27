<?php
    // prettyPrint function to output variables in a readable format
    function prettyPrint($var) {
        echo '<pre>';
            print_r($var);
        echo '</pre>';
    }

    function getTopics($dbConn) {
        $query = $dbConn->prepare("SHOW COLUMNS FROM questions LIKE 'topic'");
        $query->execute();
        $topicData = $query->fetch(PDO::FETCH_ASSOC);

        // Extract enum values using regular expression
        preg_match_all("/'([^']+)'/", $topicData['Type'], $matches);
    
        // Extracted enum values
        $topics = $matches[1];

        return $topics;
    }

//make topic var
    function quizSetup($topic, $count, $dbConn) {
        $query = $dbConn->prepare("SELECT COUNT(*) FROM questions WHERE topic = 2");
        $query->execute();
        $totalquestions = $query->fetchColumn();
        // prettyPrint($totalquestions);
        $allQuestions = range(0, $totalquestions);
        shuffle($allQuestions);
        $questionsIndex = array_slice($allQuestions, 0, $count);
        // prettyPrint($questionsIndex);
        return $questionsIndex;
    }

    function getQuestion($id, $dbConn) {
        $query = $dbConn->prepare("SELECT * FROM questions WHERE id = $id");
        $query->execute();
        $questionData = $query->fetch(PDO::FETCH_ASSOC);
        // prettyPrint($questionData);
        $question = $questionData['question_text'];
        // prettyPrint($question);

        $answers = [];
        foreach (range(1, 5) as $index) {
            $answerKey = "answer_$index";
            if (isset($questionData[$answerKey])) {
                $answers[] = $questionData[$answerKey];
            }
        }
        $inputType = 'radio';
        if (strlen($questionData['correct']) > 3) {
            $inputType = 'checkbox';
        } 
        // prettyPrint($inputType);
        return [
            'question' => $question,
            'answers' => $answers,
            'inputType' => $inputType,
        ];
    }

    function getAnswers($id, $dbConn) {
        $query = $dbConn->prepare("SELECT * FROM questions WHERE id = $id");
        $query->execute();
        $questionData = $query->fetch(PDO::FETCH_ASSOC);
        $correctAnswerIndex = extractIntegers($questionData['correct']);
        // prettyPrint($correctAnswerIndex);
        foreach($correctAnswerIndex as $i) {
            $correctAnswer = $questionData['answer_'.$i];
            $correctAnswers[] = $correctAnswer;
        }
        return $correctAnswers;
    }

    function extractIntegers($string) {
        preg_match_all('/\d+/', $string, $matches);
        return $matches[0];
    }

    function getMessage($points, $totalPoints) {
        $messages = [
            "Very disappointing. You might need more practice.",
            "Bad performance. Let's work on it.",
            "Oh no, that didn't go well. Keep practicing.",
            "Hmm, you might want to try again.",
            "Not bad, but there's room for improvement.",
            "Good effort! You're doing well.",
            "Great work! Keep it up.",
            "Amazing job! You did exceptionally well.",
            "Incredible! You're on fire!",
            "God-like performance! You are absolutely phenomenal!",
            "Extraordinary! You're out of this world!",
        ];
        $messageIndexPrecentage = ($points / $totalPoints) *10;
        $messageIndex = intval($messageIndexPrecentage);
        return $messages[$messageIndex];
    }
?>