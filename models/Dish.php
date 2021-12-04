<?php 
  class Post {
    // DB stuff
    
    private $conn;
    private $table = 'dishes';

    // Dish Properties
    public $id;
    public $restaurant_id;
    public $dishname;
    public $cooking_time;
    public $ingredients;
    public $dish_price;
    public $pic_one;
    public $pic_two;
    public $pic_three;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get dishes
    public function read() {
      // Create query
      $query = 'SELECT r.restaurant_name as restaurant_name,
       d.id, 
       d.restaurant_id,  
       d.cooking_time,
       d.dishname,
       d.ingredients,
       d.dish_price,
       d.pic_one,
       d.pic_two,
       d.pic_three,
       d.created_at
      FROM ' . $this->table . ' d
      LEFT JOIN
      restaurants r ON d.restaurant_id = r.restaurant_id
                                ORDER BY
                                  d.created_at DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();
      return $stmt;
    }

    // Get Single Dish
    public function read_single() {
          // Create query
          $query = 'SELECT r.restaurant_name as restaurant_name,
       d.id, 
       d.restaurant_id,
       d.dishname,
       d.cooking_time,
       d.ingredients,
       d.dish_price,
       d.pic_one,
       d.pic_two,
       d.pic_three,
       d.created_at

     FROM ' . $this->table . ' d LEFT JOIN
                                    restaurants r ON d.restaurant_id = r.restaurant_id
                                    WHERE
                                      d.id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties

          $this->id = $row['id'];
          $this->restaurant_id = $row['restaurant_id'];
          $this->dishname = $row['dishname'];
          $this->cooking_time = $row['cooking_time'];
          $this->ingredients = $row['ingredients'];
          $this->dish_price = $row['dish_price'];
          $this->pic_one = $row['pic_one'];
          $this->pic_two = $row['pic_two'];
          $this->pic_three = $row['pic_three'];
          $this->created_at = $row['created_at'];

    }

    // Create Dish
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET
          id = :id,
          restaurant_id = :restaurant_id,
          dishname = :dishname,
          cooking_time = :cooking_time,
          ingredients = :ingredients,
          dish_price = :dish_price 
          '
          ;

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));
          $this->restaurant_id = htmlspecialchars(strip_tags($this->restaurant_id));
          $this->dishname = htmlspecialchars(strip_tags($this->dishname));
          $this->cooking_time = htmlspecialchars(strip_tags($this->cooking_time));
          $this->ingredients = htmlspecialchars(strip_tags($this->ingredients));
          $this->dish_price = htmlspecialchars(strip_tags($this->dish_price));

          // Bind data
          $stmt->bindParam(':id', $this->id);
          $stmt->bindParam(':restaurant_id', $this->restaurant_id);
          $stmt->bindParam(':dishname', $this->dishname);
          $stmt->bindParam(':cooking_time', $this->cooking_time);
          $stmt->bindParam(':ingredients', $this->ingredients);
          $stmt->bindParam(':dish_price', $this->dish_price);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }


// UPDATE Dish
public function update() {
  // Create query
  $query = 'UPDATE ' .
     $this->table . '
  SET
  restaurant_id = :restaurant_id,
  dishname = :dishname,
  cooking_time = :cooking_time,
  ingredients = :ingredients,
  dish_price = :dish_price 
  WHERE id =:id' ;

  // Prepare statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->id = htmlspecialchars(strip_tags($this->id));
  $this->restaurant_id = htmlspecialchars(strip_tags($this->restaurant_id));
  $this->dishname = htmlspecialchars(strip_tags($this->dishname));
  $this->cooking_time = htmlspecialchars(strip_tags($this->cooking_time));
  $this->ingredients = htmlspecialchars(strip_tags($this->ingredients));
  $this->dish_price = htmlspecialchars(strip_tags($this->dish_price));

  // Bind data
  $stmt->bindParam(':id', $this->id);
  $stmt->bindParam(':restaurant_id', $this->restaurant_id);
  $stmt->bindParam(':dishname', $this->dishname);
  $stmt->bindParam(':cooking_time', $this->cooking_time);
  $stmt->bindParam(':ingredients', $this->ingredients);
  $stmt->bindParam(':dish_price', $this->dish_price);

  // Execute query
  if($stmt->execute()) {
    return true;
     }

  // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

            return false;
   }

   public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
     }


}
