<?php
/*
    INCLUDE DATABASE CONNECTION
*/
include('utils/db.php');

/*
    SCHREIBE HIER DIE QUERIES
    Speichere diese immer in der Variable $queryString ab
    Bsp: SELECT * FROM books
*/

//All
$queryString = "SELECT * FROM books";

//First 10
// $queryString = "SELECT * FROM books WHERE id <= 10";
$queryString = "SELECT * FROM books LIMIT 10";

//From 25
// $queryString = "SELECT * FROM books WHERE id >= 25";
$queryString = "SELECT * FROM books LIMIT 100 OFFSET 24";

//All index 25
$queryString = "SELECT * FROM books WHERE id = 25";

//All english books
$queryString = "SELECT * FROM books WHERE language = 'english'";

//All Stephen King
$queryString = "SELECT * FROM books WHERE author = 'Stephen King'";

//All more than 500 sold
$queryString = "SELECT * FROM books WHERE sold_copies > 500";

//All less than 500 sold and german
$queryString = "SELECT * FROM books WHERE sold_copies < 500 AND language = 'Deutsch'";

//All more than 800 sold or french
$queryString = "SELECT * FROM books WHERE sold_copies > 800 OR language = 'französisch'";

//inde alle Bücher, die auf englisch sind und mehr als 500 mal verkauft wurden oder alle Bücher, die weniger als 400 mal verkauft wurden
$queryString = "SELECT * FROM books WHERE sold_copies > 500 AND language = 'english' OR sold_copies < 400";

//Zeige alle Bücher, die kein Publikationsdatum haben
$queryString = "SELECT * FROM books WHERE published_at IS null";

//Zeige alle Bücher, die nach 1900 aber vor 1950 publiziert wurden
$queryString = "SELECT * FROM books WHERE published_at > '1900-01-01' AND published_at < '1950-01-01'";

//ZZeige alle Bücher, die im April publiziert wurden
$queryString = "SELECT * FROM books WHERE MONTHNAME(published_at) = 'april'";

//ZZeige alle Bücher, die im April publiziert wurden
$queryString = "SELECT * FROM books WHERE MONTHNAME(published_at) = 'april'";

//ZZeige alle Bücher, die im April publiziert wurden
$queryString = "SELECT * FROM books WHERE MONTHNAME(published_at) = 'april'";

//Zeige alle Bücher, die mehr als 100 Jahre alt sind
$queryString = "SELECT * FROM books WHERE published_at >= DATE_SUB(NOW(),INTERVAL 100 YEAR);";

//Zeige die Bücher, die eine Bewertung zwischen 3 und 5 habenw
$queryString = "SELECT * FROM books WHERE rating > 2";

//Zeige die Bücher an, bei welchen der Begriff “The” im Titel am Anfang steht
$queryString = "SELECT * FROM books WHERE title LIKE 'the%'";

//Zeige die Bücher an, bei welchen der Begriff “the” im Titel vorkommt
$queryString = "SELECT * FROM books WHERE title LIKE '%the%'";

//Zeige die Bücher an, bei welchen der Begriff “the” im Titel vorkommt
$queryString = "SELECT * FROM books WHERE title NOT LIKE '%the%' AND subtitle NOT LIKE '%the%'";

//Zeige die Bücher an, bei welchen der Begriff “the” im Titel vorkommt
$queryString = "SELECT * FROM books WHERE author LIKE '%.%'";



//sorting

//Sortiere alle Bücher nach den verkauften Exemplaren absteigend (das meistverkaufte zuerst)
$queryString = "SELECT * FROM books ORDER BY sold_copies DESC";

//Sortiere alle Bücher nach den verkauften Exemplaren absteigend (das meistverkaufte zuerst)
$queryString = "SELECT * FROM books ORDER BY sold_copies ASC";

//Sortiere die Bücher aufsteigend nach Publikationsdatum - Bücher ohne Datum am Schluss
$queryString = "SELECT * FROM books ORDER BY published_at DESC";

//Sortiere alle Bücher nach einer zufälligen Reihenfolge
$queryString = "SELECT * FROM books ORDER BY RAND()";

//Sortiere alle Bücher zuerst nach Bewertung und dann nach Verkaufszahl beides absteigend
$queryString = "SELECT * FROM books ORDER BY rating DESC, sold_copies DESC";

//Sortiere alle Bücher so, dass zuerst die Englischen und dann die Deutschen angezeigt werden
$queryString = "SELECT * FROM books ORDER BY CASE WHEN language = 'English' THEN 1 WHEN language = 'deutsch' THEN 2 ELSE 3 END;";




//functions

//Zeige alle Bücher, welche die ID 2, 5, 6, 7, 8, 9, 18 und 23 haben
$queryString = "SELECT * FROM books WHERE id IN(2, 5, 6, 7, 8, 9, 18, 23);";

//Zeige alle Bücher, welche nicht die ID 2, 4, 8, 16 und 32 haben
$queryString = "SELECT * FROM books WHERE id NOT IN(2, 4, 8, 16, 32);";

//Füge vor jedem Publikationsdatum den String “publiziert am” hinzu (ohne PHP zu verwenden)
$queryString = "SELECT *, CONCAT('publiziert am ', published_at) AS formatted_published_at FROM books;";

//Formatiere das Datum von Y-m-d zu d.m.Y mit der Hilfe von MySQL
$queryString = "SELECT *, DATE_FORMAT(published_at, '%d/%m/%Y') AS published_at FROM books;";

//Formatiere den String wie folgt: “publiziert in der X. Woche des Jahres YYYY”
$queryString = "SELECT *, CONCAT(published_at, ' publiziert in der Woche ', WEEKOFYEAR(published_at), ' des Jahres ', YEAR(published_at)) AS published_at FROM books;";

//Transformiere den String in Grossbuchstaben
$queryString = "SELECT *, UPPER(CONCAT(published_at, ' publiziert in der Woche ', WEEKOFYEAR(published_at), ' des Jahres ', YEAR(published_at))) AS published_at FROM books;";

//Berechne vor wie vielen Tagen das Buch veröffentlicht wurde packe das Resultat in Spalte: published_days
$queryString = "SELECT *, FORMAT(";





/*
    DATEN
    Hier kannst Du Platzhalter im Query mit Daten füllen
    Bsp: ':id' => 1
*/

$data = [];



/*
    DER QUERY WIRD AUSGEFÜHRT
    Die verschiedenen Schritte für PDO
*/

try{

    // überprüfe, ob Abfrage vorhanden ist
    if($queryString == ''){
        throw new \Exception('keine Abfrage in $queryString vorhanden');
    }

    // bereite die Abfrage vor
    $query = $dbConn->prepare($queryString);

    // füge Daten für Platzhalter ein, falls vorhanden
    $query->execute($data);

    // überprüfe, ob Daten zurück gegeben werden
    if($query->rowCount() == 0) {
        throw new \Exception('Deine Abfrage gibt keine Daten zurück');
    }

    // alle Daten werden aus der DB geholt und in einem assoziativen Array gespeichert
    $books = $query->fetchAll(PDO::FETCH_ASSOC);

    

} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}

catch (\Exception $e) {
    die("Fehler: " . $e->getMessage());
}

