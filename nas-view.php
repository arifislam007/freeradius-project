<!DOCTYPE html>
<html>
<head>
    <title>View NAS Data</title>
</head>
<body>
    <h1>View NAS Data</h1>
    <h1>Insert Data into MySQL Database</h1>
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

    // SQL query to retrieve data from the "nas" table
    $sql = "SELECT * FROM nas";

    // Execute the query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the data in a table
        echo "<table border='1'>";
        echo "<tr><th>NAS Name</th><th>Short Name</th><th>Type</th><th>Ports</th><th>Secret</th><th>Server</th><th>Community</th><th>Description</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["nasname"] . "</td>";
            echo "<td>" . $row["shortname"] . "</td>";
            echo "<td>" . $row["type"] . "</td>";
            echo "<td>" . $row["ports"] . "</td>";
            echo "<td>" . $row["secret"] . "</td>";
            echo "<td>" . $row["server"] . "</td>";
            echo "<td>" . $row["community"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
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

