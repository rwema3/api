<?php 
  class Post {
    // DB stuff
    
    private $conn;
    private $table = 'restaurants';

    // Resto Properties
    public $restaurant_id;
    public $restaurant_name;
    public $owner;
    public $rating;
    public $location;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get dishes
    public function allrestaurants() {
      // Create query
      $query = 'SELECT r.restaurant_name as restaurant_name,
 
       d.restaurant_id,  
       d.restaurant_name,
       d.owner,
       d.rating,
       d.location,
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

    // Create Dish
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET
        
          restaurant_id = :restaurant_id,
          restaurant_name = :restaurant_name,
          owner = :owner,
          rating = :rating,
          location = :location
          '
          ;

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
      
          $this->restaurant_id = htmlspecialchars(strip_tags($this->restaurant_id));
          $this->restaurant_name = htmlspecialchars(strip_tags($this->restaurant_name));
          $this->owner = htmlspecialchars(strip_tags($this->owner));
          $this->rating = htmlspecialchars(strip_tags($this->rating));
          $this->location = htmlspecialchars(strip_tags($this->location));

          // Bind data
          $stmt->bindParam(':restaurant_id', $this->restaurant_id);
          $stmt->bindParam(':restaurant_name', $this->restaurant_name);
          $stmt->bindParam(':owner', $this->owner);
          $stmt->bindParam(':rating', $this->rating);
          $stmt->bindParam(':location', $this->location);

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
  
  $query = 'UPDATE ' .
     $this->table . '
  SET
  restaurant_name = :restaurant_name,
  owner = :owner,
  rating = :rating,
  location = :location

  WHERE restaurant_id =:restaurant_id' ;

  // Prepare statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  
  $this->restaurant_id = htmlspecialchars(strip_tags($this->restaurant_id));
  $this->restaurant_name = htmlspecialchars(strip_tags($this->restaurant_name));
  $this->owner = htmlspecialchars(strip_tags($this->owner));
  $this->rating = htmlspecialchars(strip_tags($this->rating));
  $this->location = htmlspecialchars(strip_tags($this->location));

  // Bind data
  $stmt->bindParam(':restaurant_id', $this->restaurant_id);
  $stmt->bindParam(':restaurant_name', $this->restaurant_name);
  $stmt->bindParam(':owner', $this->owner);
  $stmt->bindParam(':rating', $this->rating);
  $stmt->bindParam(':location', $this->location);
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
    $query = 'DELETE FROM ' . $this->table . ' WHERE restaurant_id = :restaurant_id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->restaurant_id = htmlspecialchars(strip_tags($this->restaurant_id));

    // Bind data
    $stmt->bindParam(':restaurant_id', $this->restaurant_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
     }


}
