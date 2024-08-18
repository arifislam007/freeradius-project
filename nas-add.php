<!DOCTYPE html>
<html>
<head>
    <title>Insert Data into MySQL</title>
</head>
<body>
    <h1>Insert Data into MySQL Database</h1>
    <a href="index.php">Back to Home</a> <!-- Add a link to the home page -->

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Get user input from the form
        $nasname = $_POST["nasname"];
        $shortname = $_POST["shortname"];
        $type = $_POST["type"];
        $ports = $_POST["ports"];
        $secret = $_POST["secret"];
        $server = $_POST["server"];
        $community = $_POST["community"];
        $description = $_POST["description"];

        // SQL query to insert data into the "nas" table
        $sql = "INSERT INTO nas (nasname, shortname, type, ports, secret, server, community, description)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare and execute the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $nasname, $shortname, $type, $ports, $secret, $server, $community, $description);

        if ($stmt->execute()) {
            echo "Data inserted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the database connection
        $conn->close();
    }
    ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nasname"> Mikrotik IP:</label>
        <input type="text" name="nasname" required><br><br>

        <label for="shortname">Short Name:</label>
        <input type="text" name="shortname" required><br><br>

        <label for="type">Type:</label>
        <input type="text" name="type" required><br><br>

        <label for="secret">Secret:</label>
        <input type="text" name="secret" required><br><br>

        <label for="description">Description:</label>
        <input type="text" name="description" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

