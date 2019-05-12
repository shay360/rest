<?php
require('Post.php');

try {
    $postObj = [];
    $postObj['id'] = 135;
    $postObj['title'] = 'test Title';
    $postObj['content'] = 'This is the content of the test post';
    $post = new Post($postObj);
    header('Content-type: application/json;charset=utf8');
    echo json_encode($post->returnPostAsArray());

} catch (PostException $e) {
    echo "Error: " . $e->getMessage();
}