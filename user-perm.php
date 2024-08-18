<!DOCTYPE html>
<html>
<head>
    <title>View and Delete User Permissions</title>
</head>
<body>
    <h1>View and Delete User Permissions</h1>
    <a href="index.php">Back to Home</a> <!-- Add a link to the home page -->
    </br>
    </br>

    <?php
    // Define FreeRADIUS database connection details
    $db_host = "localhost";
    $db_user = "freeradius";
    $db_password = "Free@DB#"; // Replace with your actual password
    $db_name = "freeradius";

    // Create a connection to the FreeRADIUS database
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if a delete request was made
    if (isset($_GET['delete'])) {
        $idToDelete = $_GET['delete'];
        // SQL query to delete a row from the "radusergroup" table
        $deleteQuery = "DELETE FROM radusergroup WHERE id = ?";
        
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $idToDelete);
        
        if ($stmt->execute()) {
            echo "Record deleted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // SQL query to retrieve data from the "radusergroup" table
    $query = "SELECT * FROM radusergroup";

    // Execute the query
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th><th>Group Name</th><th>Priority</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["groupname"] . "</td>";
            echo "<td>" . $row["priority"] . "</td>";
            echo "<td><a href='?delete=" . $row["id"] . "'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No records found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>

