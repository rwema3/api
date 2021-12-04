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

// Blog post query
$result = $post->read();
// Get row count
$num = $result->rowCount();

// Check if any posts
if($num > 0) {
  // Post array
  $posts_arr = array();
  $posts_arr['data'] = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $post_item = array(
      'id' => $id,
      'restaurant_id' => $restaurant_id,
      'dishaname' => $dishname,
      'cooking_time' => $cooking_time,
      'ingredients' => html_entity_decode($ingredients),
      'dish_price' => $dish_price,
      'restaurant_name' => $restaurant_name

    );

    // Push to "data"
    array_push($posts_arr, $post_item);
    // array_push($posts_arr['data'], $post_item);
  }

  // Turn to JSON & output
  echo json_encode($posts_arr);

} else {
  // No Posts
  echo json_encode(
    array('message' => 'Nta foods ziba muri iyi restaurant')
  );
}
    }
    else {
      header("HTTP/1.0 401 Unauthorized");
      header("WWW-Authenticate: Basic realm=\"Private Area\"");
      print "Sorry, You dont Have Proper Credentials";
    }
  }

  ?>


