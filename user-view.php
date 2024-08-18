<!DOCTYPE html>
<html>
<head>
    <title>View and Delete Data with Group Name</title>
</head>
<body>
    <h1>View and Delete Data with Group Name</h1>
    <a href="index.php">Back to Home</a> <!-- Add a link to the home page -->
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

    // Check if a delete request was made
    if (isset($_GET['delete'])) {
        $idToDelete = $_GET['delete'];
        // SQL query to delete a row from the "radcheck" table
        $deleteQuery = "DELETE FROM radcheck WHERE id = ?";
        
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $idToDelete);
        
        if ($stmt->execute()) {
            echo "Record deleted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // SQL query to retrieve data from radcheck and associated groupname from radusergroup
    $query = "SELECT rc.id, rc.username, rc.value, rug.groupname
              FROM radcheck rc
              LEFT JOIN radusergroup rug ON rc.username = rug.username
              WHERE rug.groupname IS NOT NULL";

    // Execute the query
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>Group</th><th>Action</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["value"] . "</td>";
            echo "<td>" . $row["groupname"] . "</td>";
            echo "<td><a href='?delete=" . $row["id"] . "'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No records found with associated group names.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>

