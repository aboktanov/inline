<?php
include 'DB.php';
//
$postsURL = 'https://jsonplaceholder.typicode.com/posts';
$commentsURL = 'https://jsonplaceholder.typicode.com/comments';
//
$postsDownloaded=0;
$commentsDownloaded=0;
//
$dbConfig = require 'dbConfig.php';
$bd = new DB($dbConfig);
// Posts
$postsJSON = file_get_contents($postsURL);
if (!empty($postsJSON)) {
    $posts = json_decode($postsJSON, TRUE);

    foreach ($posts as $post) {
        $result = $bd->query("INSERT INTO `posts`(`id`, `user_id`, `title`, `body`) VALUES (" . $bd->escape($post['id']) . "," . $bd->escape($post['userId']) . ",'" . $bd->escape($post['title']) . "','" . $bd->escape($post['body']) . "')");
        if($result){
            $postsDownloaded++;
        }
    }
} else {
    echo 'Posts not found.';
    exit();
}

// Comments
$commentsJSON = file_get_contents($commentsURL);
if (!empty($commentsJSON)) {
    $comments = json_decode($commentsJSON, TRUE);

    foreach ($comments as $comment) {
        $result = $bd->query("INSERT INTO `comments`(`id`, `post_id`, `name`, `email`, `body`) VALUES (" . $bd->escape($comment['id']) . "," . $bd->escape($comment['postId']) . ",'" . $bd->escape($comment['name']) . "','" . $bd->escape($comment['email']) . "','" . $bd->escape($comment['body']) . "')");
        if($result){
            $commentsDownloaded++;
        }
    }
} else {
    echo 'Comments not found.';
}

echo  "Загружено $postsDownloaded записей и $commentsDownloaded комментариев".PHP_EOL;