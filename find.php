<html>
<head>
    <meta name="referrer" content="no-referrer"/>
    <meta name="robots" content="noindex,nofollow"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Comments search">
    <meta name="author" content="BAU">

    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <title>Search</title>
</head>
<body class="container">
<form class="col m6 s12" action="find.php" method="post">
    <div class="row">
        <div class="input-field col m2 s4">
            <input id="comment" name="comment" type="text" class="validate" value="">
            <label for="comment">Comments</label>
        </div>
        <div class="input-field col m2 s4">
            <button class="btn waves-effect waves-light" type="submit" name="action">Найти
                <i class="material-icons right">find_in_page</i>
            </button>
        </div>
    </div>
</form>
</body>
</html>

<?php
include 'DB.php';
if (isset($_POST['comment'])) {
    if (strlen($_POST['comment']) < 3) {
        echo 'Для поиска введите не менее 3-х символов';
        exit();
    }

    //
    $dbConfig = require 'dbConfig.php';
    $bd = new DB($dbConfig);

    $results = $bd->query(
        "SELECT t1.post_id, t1.body, t2.title FROM `comments` t1 LEFT JOIN `posts` t2 on t1.post_id = t2.id WHERE t1.`body` like '%" . $bd->escape($_POST['comment']) . "%' ");

    $post_id = null;
    foreach ($results as $result) {
        if($result['post_id']!==$post_id){
            echo '<h6>'.$result['title'].'</h6>';
            $post_id=$result['post_id'];
        }
        echo '<p> ' . $result['body'] . '</p>';
    }

}