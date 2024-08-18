<!DOCTYPE html>
<html>
<head>
    <title>View Data from radgroupreply Table</title>
</head>
<body>
    <h1>User Permission Group</h1>
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

    // SQL query to retrieve data from the "radgroupreply" table
    $sql = "SELECT * FROM radgroupreply";

    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the data in a table
        echo "<table border='1'>";
        echo "<tr><th>Group Name</th><th>Attribute</th><th>Operator (op)</th><th>Value</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["groupname"] . "</td>";
            echo "<td>" . $row["attribute"] . "</td>";
            echo "<td>" . $row["op"] . "</td>";
            echo "<td>" . $row["value"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No data found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>

