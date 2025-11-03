<?php
// final.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "YOUR_USERNAME_HERE";
$password = "YOUR_PASSWORD_HERE";
$dbname = "RealEstate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

$page = isset($_GET['page']) ? $_GET['page'] : 'listings';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Real Estate MLS System</title>
</head>

<body>
    <div class="container">
        <h1>Real Estate MLS System</h1>
        <div class="nav">
            <a href="?page=listings" class="<?php if ($page == 'listings') echo 'active'; ?>">Listings</a> |
            <a href="?page=agents" class="<?php if ($page == 'agents') echo 'active'; ?>">Agents</a> |
            <a href="?page=buyers" class="<?php if ($page == 'buyers') echo 'active'; ?>">Buyers</a> |
            <a href="?page=search" class="<?php if ($page == 'search') echo 'active'; ?>">Search</a> |
            <a href="?page=custom" class="<?php if ($page == 'custom') echo 'active'; ?>">Custom Query</a>
        </div>

        <?php
        if ($page == 'listings') {
            // Display Listings
            echo "<h2>House Listings</h2>";
            $sql = "SELECT H.address, P.ownerName, P.price, H.bedrooms, H.bathrooms, H.size, L.mlsNumber
                FROM House H
                JOIN Property P ON H.address = P.address
                JOIN Listings L ON H.address = L.address";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table><tr><th>MLS Number</th><th>Address</th><th>Owner</th><th>Price</th><th>Bedrooms</th><th>Bathrooms</th><th>Size (sq ft)</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['mlsNumber']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['ownerName']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['bedrooms']}</td>
                        <td>{$row['bathrooms']}</td>
                        <td>{$row['size']}</td>
                      </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No house listings found.</p>";
            }

            echo "<h2>Business Property Listings</h2>";
            $sql = "SELECT BP.address, P.ownerName, P.price, BP.type, BP.size, L.mlsNumber
                FROM BusinessProperty BP
                JOIN Property P ON BP.address = P.address
                JOIN Listings L ON BP.address = L.address";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table><tr><th>MLS Number</th><th>Address</th><th>Owner</th><th>Price</th><th>Type</th><th>Size (sq ft)</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['mlsNumber']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['ownerName']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['type']}</td>
                        <td>{$row['size']}</td>
                      </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No business property listings found.</p>";
            }
        } elseif ($page == 'agents') {
            echo "<h2>Agents</h2>";
            $sql = "SELECT A.agentId, A.name, A.phone, F.name AS firmName, A.dateStarted
                FROM Agent A
                JOIN Firm F ON A.firmId = F.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table><tr><th>Agent ID</th><th>Name</th><th>Phone</th><th>Firm Name</th><th>Date Started</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['agentId']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['firmName']}</td>
                        <td>{$row['dateStarted']}</td>
                      </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No agents found.</p>";
            }
        } elseif ($page == 'buyers') {
            echo "<h2>Buyers</h2>";
            $sql = "SELECT * FROM Buyer";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table><tr><th>Buyer ID</th><th>Name</th><th>Phone</th><th>Property Type</th><th>Preferences</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    $preferences = "";
                    if ($row['propertyType'] == 'House') {
                        $preferences = "{$row['bedrooms']} bedrooms, {$row['bathrooms']} bathrooms";
                    } else {
                        $preferences = $row['businessPropertyType'];
                    }
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['propertyType']}</td>
                        <td>$preferences</td>
                      </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No buyers found.</p>";
            }
        } elseif ($page == 'search') {
        ?>
            <div class="form-section">
                <h2>Search Houses</h2>
                <form method="post" action="?page=search">
                    <label>Minimum Price:</label>
                    <input type="number" name="min_price" min="0">
                    <label>Maximum Price:</label>
                    <input type="number" name="max_price" min="0">
                    <label>Bedrooms:</label>
                    <input type="number" name="bedrooms" min="1">
                    <label>Bathrooms:</label>
                    <input type="number" name="bathrooms" min="1">
                    <input type="submit" name="search_houses" value="Search Houses">
                </form>
            </div>
            <?php
            if (isset($_POST['search_houses'])) {
                $min_price = $_POST['min_price'];
                $max_price = $_POST['max_price'];
                $bedrooms = $_POST['bedrooms'];
                $bathrooms = $_POST['bathrooms'];

                $sql = "SELECT H.address, P.ownerName, P.price, H.bedrooms, H.bathrooms, H.size
                    FROM House H
                    JOIN Property P ON H.address = P.address
                    JOIN Listings L ON H.address = L.address
                    WHERE P.price BETWEEN $min_price AND $max_price
                    AND H.bedrooms = $bedrooms
                    AND H.bathrooms = $bathrooms
                    ORDER BY P.price DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "<h3>Search Results</h3>";
                    echo "<table><tr><th>Address</th><th>Owner</th><th>Price</th><th>Bedrooms</th><th>Bathrooms</th><th>Size (sq ft)</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['address']}</td>
                            <td>{$row['ownerName']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['bedrooms']}</td>
                            <td>{$row['bathrooms']}</td>
                            <td>{$row['size']}</td>
                          </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No houses found matching your criteria.</p>";
                }
            }
        } elseif ($page == 'custom') {
            ?>
            <div class="form-section">
                <h2>Custom Query</h2>
                <form method="post" action="?page=custom">
                    <label>Enter your SELECT query:</label>
                    <textarea name="custom_query" rows="5"></textarea>
                    <input type="submit" name="run_query" value="Run Query">
                </form>
            </div>
        <?php
            if (isset($_POST['run_query'])) {
                $custom_query = $_POST['custom_query'];
                if (stripos(trim($custom_query), 'SELECT') === 0) {
                    $result = $conn->query($custom_query);
                    if ($result) {
                        if ($result->num_rows > 0) {
                            echo "<h3>Query Results</h3>";
                            echo "<table><tr>";
                            while ($field = $result->fetch_field()) {
                                echo "<th>{$field->name}</th>";
                            }
                            echo "</tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($row as $value) {
                                    echo "<td>$value</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p>No results found.</p>";
                        }
                    } else {
                        echo "<p class='error'>Error executing query: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p class='error'>Only SELECT queries are allowed.</p>";
                }
            }
        }
        $conn->close();
        ?>
    </div>
</body>

</html>