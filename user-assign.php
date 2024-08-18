<!DOCTYPE html>
<html>
<head>
    <title>Add or Update User Permissions</title>
</head>
<body>
    <h1>Add or Update User Permissions</h1>
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

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input from the form
        $operation = $_POST["operation"];
        $username = $_POST["username"];
        $groupname = $_POST["groupname"];
        $priority = $_POST["priority"];

        if ($operation === "add") {
            // SQL query to insert data into the "radusergroup" table
            $sql = "INSERT INTO radusergroup (username, groupname, priority) VALUES (?, ?, ?)";
        } elseif ($operation === "update") {
            // SQL query to update data in the "radusergroup" table
            $sql = "UPDATE radusergroup SET priority = ? WHERE username = ? AND groupname = ?";
        }

        // Prepare and execute the statement
        $stmt = $conn->prepare($sql);

        if ($operation === "add") {
            $stmt->bind_param("ssi", $username, $groupname, $priority);
        } elseif ($operation === "update") {
            $stmt->bind_param("iss", $priority, $username, $groupname);
        }

        if ($stmt->execute()) {
            echo "Data " . ($operation === "add" ? "added" : "updated") . " successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    ?>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="operation">Select Operation:</label>
        <select name="operation">
            <option value="add">Add</option>
            <option value="update">Update</option>
        </select><br><br>

        <label for="username">Select Username:</label>
        <select name="username">
            <?php
            // SQL query to fetch usernames from the "radcheck" table
            $sql = "SELECT DISTINCT username FROM radcheck";

            // Execute the query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["username"] . "'>" . $row["username"] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="groupname">Select Group Name:</label>
        <select name="groupname">
            <?php
            // SQL query to fetch groupnames from the "radgroupreply" table
            $sql = "SELECT DISTINCT groupname FROM radgroupreply";

            // Execute the query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["groupname"] . "'>" . $row["groupname"] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="priority">Priority:</label>
        <input type="number" name="priority" required><br><br>

        <input type="submit" value="Submit">
    </form>
    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>

