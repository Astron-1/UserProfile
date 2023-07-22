<?php include("config.php"); ?>
<?php
try {

     if ($_SERVER["REQUEST_METHOD"] === "POST") {
          $email = mysqli_real_escape_string($conn, $_POST["email"]);
          $password = mysqli_real_escape_string($conn, $_POST["password"]);

          $passHash = password_hash($password, PASSWORD_BCRYPT);

          $stmt = $conn->prepare("SELECT * FROM $tableName WHERE email = ?");
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $result = $stmt->get_result();
          $stmt->close();

          if ($result->num_rows > 0) {

               http_response_code(409); // Conflict
               echo json_encode(array("message" => "Email already exists.", "status" => 409));
          } else {


               $stmt = $conn->prepare("INSERT INTO $tableName (email,pass) VALUES (?,?)");
               $stmt->bind_param("ss", $email, $passHash);
               $stmt->execute();
               $stmt->close();

               // perform here mysli_escape seq and prepare sql statements to bind
               // Perform any server-side validation or database operations here
               $conn->close();
               http_response_code(201);//ok response
               $response = array(
                    array("message" => "Data inserted successfully"),
                    array("status" => 201)
               );
               echo json_encode($response);
          }

     } else {
          echo "Bad request.";
          http_response_code(400);
          $response = array(
               array("message" => "Bad Request!!"),
               array("status" => 400)
          );
          echo json_encode($response);
     }
} catch (Throwable $th) {
     $err = $th->getMessage();
     http_response_code(500);
     $response = array(
          array("message" => "Internal Server Error $err"),
          array("status" => 500)
     );
     echo json_encode($response);
}

?>