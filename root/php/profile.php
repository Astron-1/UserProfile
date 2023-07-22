<?php
// Replace the following parameters with your MongoDB server configuration
$mongoHost = 'localhost'; // MongoDB server hostname or IP address
$mongoPort = '27017'; // MongoDB server port
$mongoDB = 'your_database_name'; // Database name
$collectionName = 'your_collection_name'; // Collection name

require('vendor/autoload.php');

try {
    // Establish the MongoDB connection
    $mongoClient = new MongoDB\Client("mongodb://{$mongoHost}:{$mongoPort}");

    // Select the database and collection
    $db = $mongoClient->{$mongoDB};
    $collection = $db->{$collectionName};

    // Get form data submitted via POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $name = filter_input(INPUT_POST, "Name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dob = filter_input(INPUT_POST, "DOB", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $contact = filter_input(INPUT_POST, "Contact", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $state = filter_input(INPUT_POST, "inputState", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $city = filter_input(INPUT_POST, "inputCity", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $zip = filter_input(INPUT_POST, "inputZip", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $address = filter_input(INPUT_POST, "inputAddress", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Prepare the update query
        $updateQuery = [
            '$set' => [
                'Name' => $name,
                'DOB' => $dob,
                'Contact' => $contact,
                'State' => $state,
                'City' => $city,
                'Zip' => $zip,
                'Address' => $address,
            ],
        ];

        $updateResult = $collection->updateOne(['email' => $email], $updateQuery);

        if ($updateResult->getModifiedCount() > 0) {
            echo "Details updated successfully!";
        } else {
            echo "No matching document found or no changes were made.";
        }
    }
} catch (MongoDB\Driver\Exception\ConnectionException $e) {
    die("Failed to connect to MongoDB: " . $e->getMessage());
}
?>
