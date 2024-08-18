<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
</head>
<body>
    <h1>Add User</h1>
    <a href="index.php">Back to Home</a> <!-- Add a link to the home page -->
    </br>
    </br>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Get user input from the form
        $username = $_POST["username"];
        $attribute = $_POST["attribute"];
        $op = $_POST["op"];
        $value = $_POST["value"];

        // SQL query to insert data into the "radcheck" table
        $sql = "INSERT INTO radcheck (username, attribute, op, value) VALUES (?, ?, ?, ?)";

        // Prepare and execute the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $attribute, $op, $value);

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
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        
        <label for="attribute">Attribute:</label>
        <input type="text" name="attribute" required><br><br>

        <label for="op">Operator (e.g., := or ==):</label>
        <input type="text" name="op" required><br><br>

        <label for="value">Value:</label>
        <input type="text" name="value" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

