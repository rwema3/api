<?php 
include_once '../../config/Database.php';
include_once '../../models/Dish.php';
header('Content-Type: application/json');

  if( !isset($_SERVER [ 'PHP_AUTH_USER'])){
  header("WWW-Authenticate: Basic realm=\"Private Area\"");
  header("HTTP/1.0 401 Unauthorized");
  print "Sorry, You dont Have Proper Credentials";
  header('Content-Type: application/json');
  
  }

  else {
    if(($_SERVER [ 'PHP_AUTH_USER'] == 'rwema' && ($_SERVER [ 'PHP_AUTH_PW'] == 'pelin123') )){
      


  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Post($db);

  // Get ID
  $post->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $post->read_single();

  // Create array
  $post_arr = array(
    'id' => $post->id,
    'restaurant_id' => $post->restaurant_id,
    'dishname' => $post->dishname,
    'cooking_time' => $post->cooking_time,
    'ingredients' => $post->ingredients,
    'created_at' => $post->created_at
  );

  // Make JSON
  print_r(json_encode($post_arr));

  
}
else {
  header("HTTP/1.0 401 Unauthorized");
  header("WWW-Authenticate: Basic realm=\"Private Area\"");
  print "Sorry, You dont Have Proper Credentials";
}
}

?>