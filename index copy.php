<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO und MySQL</title>

    <!-- import bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- import bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<!-- PHP -->
<?php
    include 'utils/queries.php';
    include 'utils/helper.php';
    prettyPrint($books);
?>
<!-- /PHP -->

<header>
    <!-- As a heading -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Meine Bücher</span>
        </div>
    </nav>
</header>
    
<main>

    <section class="container">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Titel</th>
                    <th scope="col">Beschreibung</th>
                    <th scope="col">Autor</th>
                    <th scope="col">publiziert</th>
                    <th scope="col"><i class="bi bi-bar-chart-fill"></i></th>
                    <th scope="col"><i class="bi bi-translate"></i></th>
                    <th scope="col"><i class="bi bi-star-fill"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($books as $key => $book): ?>
                    <tr>
                        <th scope="row"><?= $key + 1 ?></th>
                        <td><?= $book['id']; ?></td>
                        <td><?= $book['title']; ?></td>
                        <td><?= substr($book['description'],0,40).'...'; ?></td>
                        <td><?= $book['author']; ?></td>
                        <td><?= date_format(date_create($book['published_at']),"d.m.Y"); ?></td>
                        <td><?= $book['sold_copies']; ?></td>
                        <td><?= $book['language']; ?></td>
                        <td><?= $book['rating']; ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


    </section>

</main>



<footer></footer>


</body>
</html>