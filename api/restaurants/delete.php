<?php 
include_once '../../config/Database.php';
include_once '../../models/Restaurants.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

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

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $post->restaurant_id = $data->restaurant_id;

  // Delete post
  if($post->delete()) {
    echo json_encode(
      array('message' => 'Restaurant was Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Restaurant was not Deleted')
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

