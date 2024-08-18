<!DOCTYPE html>
<html>
<head>
    <title>Remove NAS Client</title>
</head>
<body>
    <h1>Remove NAS Client</h1>
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

        // Get the NAS client's NAS name for removal
        $nasname = $_POST["nasname"];

        // SQL query to delete a NAS client from the "nas" table
        $sql = "DELETE FROM nas WHERE nasname = ?";

        // Prepare and execute the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nasname);

        if ($stmt->execute()) {
            echo "NAS client removed successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the database connection
        $conn->close();
    }
    ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nasname">Select NAS Name:</label>
        <select name="nasname">
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

            // SQL query to fetch NAS names from the "nas" table
            $sql = "SELECT nasname FROM nas";

            // Execute the query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["nasname"] . "'>" . $row["nasname"] . "</option>";
                }
            }

            // Close the database connection
            $conn->close();
            ?>
        </select><br><br>

        <input type="submit" value="Remove NAS Client">
    </form>
</body>
</html>

