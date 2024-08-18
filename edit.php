<!DOCTYPE html>
<html>
<head>
    <title>Edit and Update Data</title>
</head>
<body>
    <h1>Edit and Update Data</h1>
    <a href="view.php">Back to View</a> <!-- Link to the view page -->
    </br>
    </br>

    <?php
    // Define MySQL database connection details
    $db_host = "localhost";
    $db_user = "freeradius";
    $db_password = "Free@DB#"; // Replace with your actual password
    $db_name = "freeradius";

    // Create a connection to the MySQL database
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if an ID parameter is provided in the URL
    if (isset($_GET['id'])) {
        $idToUpdate = $_GET['id'];

        // Retrieve the current record based on the provided ID
        $query = "SELECT * FROM radcheck WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idToUpdate);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            // Check if the form is submitted for updating
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get the updated value from the form
                $updatedValue = $_POST["updated_value"];

                // SQL query to update the "value" field in the "radcheck" table
                $updateQuery = "UPDATE radcheck SET value = ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $updatedValue, $idToUpdate);

                if ($updateStmt->execute()) {
                    echo "Record updated successfully!";
                } else {
                    echo "Error updating record: " . $updateStmt->error;
                }
            }
            
            // Display the current record and allow for editing
            echo "<form method='post' action='edit.php?id=$idToUpdate'>";
            echo "ID: " . $row["id"] . "<br>";
            echo "Username: " . $row["username"] . "<br>";
            echo "Attribute: " . $row["attribute"] . "<br>";
            echo "Operator: " . $row["op"] . "<br>";
            echo "Current Value: " . $row["value"] . "<br>";
            echo "Updated Value: <input type='text' name='updated_value' required><br>";
            echo "<input type='submit' value='Update'>";
            echo "</form>";
        } else {
            echo "Record not found with the provided ID.";
        }
    } else {
        echo "No ID parameter provided.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>

