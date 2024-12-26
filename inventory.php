<?php
include("include/connect.php");

if (isset($_POST['ins'])) {
    $pname = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];
    $image = $_FILES['photo']['name'];
    $temp_image = $_FILES['photo']['tmp_name'];

    if ($category == "all") {
        echo "<script>alert('Select category'); setTimeout(function(){ window.location.href = 'inventory.php'; }, 100);</script>";
        exit();
    }

    // Validate and move uploaded file
    if (move_uploaded_file($temp_image, "product_images/$image")) {
        $stmt = $con->prepare("INSERT INTO products (pname, category, description, price, qtyavail, img, brand) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiss", $pname, $category, $description, $price, $quantity, $image, $brand);

        if ($stmt->execute()) {
            echo "<script>alert('Successfully entered product');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Failed to upload image.');</script>";
    }
}

if (isset($_GET['pid'])) {
    $id = $_GET['pid'];
    $stmt = $con->prepare("DELETE FROM products WHERE pid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['submitt'])) {
    $pname = $_POST['name1'];
    $category = $_POST['category1'];
    $description = $_POST['description1'];
    $quantity = $_POST['quantity1'];
    $price = $_POST['price1'];
    $brand = $_POST['brand1'];
    $image = $_FILES['photo1']['name'];
    $temp_image = $_FILES['photo1']['tmp_name'];
    $pid2 = $_POST['pid1'];
    $image2 = $_POST['prevphoto'];
    $prevcat = $_POST['prev'];

    if ($category == "all") {
        $category = $prevcat;
    }

    // Validate and move uploaded file if a new image is provided
    if (!empty($image) && move_uploaded_file($temp_image, "product_images/$image")) {
        $stmt = $con->prepare("UPDATE products SET pname = ?, category = ?, description = ?, qtyavail = ?, brand = ?, price = ?, img = ? WHERE pid = ?");
        $stmt->bind_param("sssdissi", $pname, $category, $description, $quantity, $brand, $price, $image, $pid2);
    } else {
        $stmt = $con->prepare("UPDATE products SET pname = ?, category = ?, description = ?, qtyavail = ?, brand = ?, price = ?, img = ? WHERE pid = ?");
        $stmt->bind_param("sssdissi", $pname, $category, $description, $quantity, $brand, $price, $image2, $pid2);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Successfully updated product');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

if (isset($_GET['odd'])) {
    $oid = $_GET['odd'];
    $stmt = $con->prepare("UPDATE orders SET datedel = CURDATE() WHERE oid = ?");
    $stmt->bind_param("i", $oid);
    $stmt->execute();
    $stmt->close();
    header("Location: inventory.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ecommerce Inventory Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Your CSS styles here */
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container ```php
1">
        <div class="form-container">
            <h2>Insert Product</h2>
            <form id="insert-form" action="inventory.php" enctype="multipart/form-data" method="post">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="category">Category:</label>
                <select id="category-filter" name="category" required>
                    <option value="all">All</option>
                    <option value="keyboard">Keyboard</option>
                    <option value="motherboard">Motherboard</option>
                    <option value="mouse">Mouse</option>
                    <option value="cpu">CPU</option>
                    <option value="gpu">GPU</option>
                    <option value="ram">RAM</option>
                </select>
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required min='0'>
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required min='0'>
                <label for="image">Image:</label>
                <input type="file" name="photo" id="fileInput" required>
                <label for="brand">Brand:</label>
                <input type="text" id="brand" name="brand" required>
                <button name="ins" type="submit" class="insert-btn">Save</button>
            </form>
        </div>
        <div class="search-container">
            <h2>Search Product</h2>
            <form id="search-form" action="inventory.php" method="post">
                <label for="search">Search:</label>
                <input type="text" id="search" name="search">
                <label for="category-filter">Category:</label>
                <select id="category-filter" name="cat">
                    <option value="all">All</option>
                    <option value="keyboard">Keyboard</option>
                    <option value="motherboard">Motherboard</option>
                    <option value="mouse">Mouse</option>
                    <option value="cpu">CPU</option>
                    <option value="gpu">GPU</option>
                    <option value="ram">RAM</option>
                </select>
                <button type="submit" id="search-btn" name="search1">Search</button>
            </form>
            <div class="inventory-container">
                <div id="product-list">
                    <?php
                    if (isset($_GET['pidd'])) {
                        $id = $_GET['pidd'];
                        $stmt = $con->prepare("SELECT * FROM products WHERE pid = ?");
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $pid = $row['pid'];
                        $pname = $row['pname'];
                        $desc = $row['description'];
                        $qty = $row['qtyavail'];
                        $price = $row['price'];
                        $cat = $row['category'];
                        $img = $row['img'];
                        $brand = $row['brand'];
                        echo "<form id='insert-form' action='inventory.php' enctype='multipart/form-data' method='post'>
                                <input type='number' style='display: none;' name='pid1' value='$pid'>
                                <input type='text' style='display: none;' name='prevphoto' value='$img'>
                                <input type='text' style='display: none;' name='prev' value='$cat'>
                                <label for='name'>Product Name:</label>
                                <input type='text' id='name' name='name1' value='$pname' required>
                                <label for='category'>Category:</label>
                                <select id='category-filter' name='category1'>
                                    <option value='all'>All</option>
                                    <option value='keyboard'>Keyboard</option>
                                    <option value='motherboard'>Motherboard</option>
                                    <option value='mouse'>Mouse</option>
                                    <option value='cpu'>CPU</option>
                                    <option value='gpu'>GPU</option>
                                    <option value='ram'>RAM</option>
                                </select>
                                <label for='description'>Description:</label>
                                <input type='text' id='description' name='description1' value='$desc' required>
                                <label for='price'>Price:</label>
                                ```php
                                <input type='number' id='price' name='price1' value='$price' required min='0'>
                                <label for='quantity'>Quantity:</label>
                                <input type='number' id='quantity' name='quantity1' value='$qty' required min='0'>
                                <label for='image'>Image:</label>
                                <input type='file' name='photo1' id='fileInput'>
                                <label for='brand'>Brand:</label>
                                <input type='text' id='brand' name='brand1' value='$brand' required>
                                <button name='submitt' type='submit' class='insert-btn'>Save</button>
                            </form>";
                    }

                    if (isset($_POST['search1'])) {
                        $search = $_POST['search'];
                        $category = $_POST['cat'];
                        $query = "SELECT * FROM products WHERE (pname LIKE ? OR brand LIKE ? OR description LIKE ?)";
                        $searchTerm = "%$search%";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($category != "all") {
                            $query .= " AND category = ?";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("ss", $searchTerm, $category);
                        }

                        if ($result) {
                            echo "
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Image</th>
                                            <th>Brand</th>
                                            <th>Delete</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        }

                        while ($row = $result->fetch_assoc()) {
                            $pid = $row['pid'];
                            $pname = $row['pname'];
                            $desc = $row['description'];
                            $qty = $row['qtyavail'];
                            $price = $row['price'];
                            $cat = $row['category'];
                            $img = $row['img'];
                            $brand = $row['brand'];

                            echo "<tr>
                                    <td>$pname</td>
                                    <td style='max-width: 300px; max-height: 100px; overflow-x: auto; overflow-y: auto;'>$desc</td>
                                    <td>$cat</td>
                                    <td>$price</td>
                                    <td>$qty</td>
                                    <td><img src='product_images/$img' alt='' /></td>
                                    <td>$brand</td>
                                    <td><a href='inventory.php?pid=$pid' class='insert-btn'>Delete</a></td>
                                    <td><a href='inventory.php?pidd=$pid' class='insert-btn'>Update</a></td>
                                  </tr>";
                        }

                        if ($result) {
                            echo "
                                    </tbody>
                                </table>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container11">
        <div class="order-container">
            <h1>List of Orders</h1>
            <div class="btns">
                <a href='inventory.php?a=1'><button id="all-btn">All</button></a>
                <a href='inventory.php?d=1'><button id="delivered-btn">Delivered</button></a>
                <a href='inventory.php?u=1'><button id="undelivered-btn">Undelivered</button></a>
            </div>

            <table id="tab1" style="width: auto; margin: 0 auto;">
                <thead>
                    <tr>
                        <th>UserName</th>
                        <th>OrderID</th>
                        <th>DateOrdered</th>
                        <th>DateDelivered</th>
                        <th>PaymentMethod</th>
                        <th>Address</th>
                        <th>Set</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['d'])) {
                        $query = "SELECT * FROM orders JOIN accounts ON orders.aid = accounts.aid WHERE datedel IS NOT NULL";
                        $result = mysqli_query($con, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $aname = $row['username'];
                            $oid = $row['oid'];
                            $dateod = $row ['dateod'];
                            $datedel = $row['datedel'];
                            $add = $row['address'];
                            $pri = $row['total'];

                            if (empty($datedel)) {
                                $datedel = "Not Delivered";
                            }
                            echo "
                                <tr>
                                    <td>$aname</td>
                                    <td>$oid</td>
                                    <td>$dateod</td>
                                    <td>$datedel</td>
                                    <td>$pri</td>
                                    <td>$add</td>";
                            if ($datedel == "Not Delivered") {
                                echo "<td><a href='inventory.php?odd=$oid'><button id='oupdate-btn'>SET</button></a></td>";
                            }
                            echo "</tr>";
                        }
                    } elseif (isset($_GET['u'])) {
                        $query = "SELECT * FROM orders JOIN accounts ON orders.aid = accounts.aid WHERE datedel IS NULL";
                        $result = mysqli_query($con, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $aname = $row['username'];
                            $oid = $row['oid'];
                            $dateod = $row['dateod'];
                            $datedel = $row['datedel'];
                            $add = $row['address'];
                            $pri = $row['total'];

                            if (empty($datedel)) {
                                $datedel = "Not Delivered";
                            }
                            echo "
                                <tr>
                                    <td>$aname</td>
                                    <td>$oid</td>
                                    <td>$dateod</td>
                                    <td>$datedel</td>
                                    <td>$pri</td>
                                    <td>$add</td>";
                            if ($datedel == "Not Delivered") {
                                echo "<td><a href='inventory.php?odd=$oid'><button id='oupdate-btn'>SET</button></a></td>";
                            }
                            echo "</tr>";
                        }
                    } elseif (isset($_GET['a'])) {
                        $query = "SELECT * FROM orders JOIN accounts ON orders.aid = accounts.aid";
                        $result = mysqli_query($con, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $aname = $row['username'];
                            $oid = $row['oid'];
                            $dateod = $row['dateod'];
                            $datedel = $row['datedel'];
                            $add = $row['address'];
                            $pri = $row['total'];

                            if (empty($datedel)) {
                                $datedel = "Not Delivered";
                            }
                            echo "
                                <tr>
                                    <td>$aname</td>
                                    <td>$oid</td>
                                    <td>$dateod</td>
                                    <td>$datedel</td>
                                    <td>$pri</td>
                                    <td>$add</td>";
                            if ($datedel == "Not Delivered") {
                                echo "<td><a href='inventory.php?odd=$oid'><button id='oupdate-btn'>SET</button></a></td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        $query = "SELECT * FROM orders JOIN accounts ON orders.aid = accounts.aid";
                        $result = mysqli_query($con, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $aname = $row['username'];
                            $oid = $row['oid'];
                            $dateod = $row['dateod'];
                            $datedel = $row['datedel'];
                            $add = $row['address'];
                            $pri = $row['total'];

                            if (empty($datedel)) {
                                $datedel = "Not Delivered";
                            }
                            echo "
                                <tr>
                                    <td>$aname</td>
                                    <td>$oid</td>
                                    <td>$dateod</td>
                                    <td>$datedel</td>
                                    <td>$pri</td>
                                    <td>$add</td>";
                            if ($datedel == "Not Delivered") {
                                echo "<td><a href='inventory.php?odd=$oid'><button id='oupdate-btn'>SET</button></a></td>";
                            }
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<script>
window.addEventListener("unload", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "logout.php", false);
    xhr.send();
});
</script>
