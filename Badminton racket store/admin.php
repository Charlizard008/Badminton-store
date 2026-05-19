<?php
require_once 'data.php';

// Handle Form Submission (Adding a new Racket)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_racket'])) {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    
    // Handle Image Upload Name
    $image_name = $_FILES['racket_image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image_name);

    // Basic upload handling (moves file to your images folder)
    if (move_uploaded_file($_FILES['racket_image']['tmp_name'], $target_file)) {
        // Use prepared statements to insert data safely
        $stmt = $conn->prepare("INSERT INTO rackets (brand, model, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $brand, $model, $price, $image_name);
        
        if ($stmt->execute()) {
            header("Location: admin.php?status=added");
            exit();
        } else {
            echo "<script>alert('Database Error: Unable to add product');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Failed to upload image. Make sure the \"images\" folder exists.');</script>";
    }
}

// Fetch all rackets to display in the table
$sql = "SELECT * FROM rackets";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management System | SmashZone</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <div class="admin-container">
        <header class="admin-header">
            <h1>SmashZone Inventory Management System</h1>
            <a href="index.html" class="back-btn">Go to Storefront</a>
        </header>

        <section class="form-section">
            <h2>Add New Racket to Inventory</h2>
            <form action="admin.php" method="POST" enctype="multipart/form-data" class="admin-form">
                <input type="hidden" name="add_racket" value="1">
                
                <div class="form-group">
                    <label for="brand">Brand Name:</label>
                    <input type="text" id="brand" name="brand" placeholder="e.g., YONEX, Li-NING" required>
                </div>

                <div class="form-group">
                    <label for="model">Model Name:</label>
                    <input type="text" id="model" name="model" placeholder="e.g., Astrox 99" required>
                </div>

                <div class="form-group">
                    <label for="price">Price (RM):</label>
                    <input type="number" id="price" name="price" step="0.01" placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label for="racket_image">Product Image:</label>
                    <input type="file" id="racket_image" name="racket_image" accept="image/*" required>
                </div>

                <button type="submit" class="submit-btn">Add Product</button>
            </form>
        </section>

        <hr class="divider">

        <section class="table-section">
            <h2>Current Stock Levels</h2>
            <table class="racket-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><img src='images/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['model']) . "' class='table-img'></td>";
                            echo "<td>" . htmlspecialchars($row['brand']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['model']) . "</td>";
                            echo "<td>RM " . number_format($row['price'], 2) . "</td>";
                            echo "<td><a href='delete.php?id=" . $row['id'] . "' class='delete-btn' onclick='return confirmDelete(event, \"" . htmlspecialchars($row['model']) . "\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='no-data'>No stock available in the database.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <script src="app.js"></script>
</body>
</html>