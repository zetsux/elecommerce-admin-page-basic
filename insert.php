<?php
    require 'functions.php';
    $dbConn = mysqli_connect("localhost", "root", "", "phplearn");

    if (isset($_POST["isubmit"])) {
        if (addProduct($_POST) > 0) {
            echo "
                <script>
                    alert('Succesfully added the product!');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Failed adding the product..');
                    document.location.href = 'index.php';
                </script>
            ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Product</title>
</head>
<body>
    <h1>Adding New Product</h1>

    <form method="post">
        <ul>
            <li>
                <label for="iname">Product Name : </label>
                <input type="text" name="iname" id="iname" required>
            </li>
            <li>
                <label for="ibrand">Brand : </label>
                <input type="text" name="ibrand" id="ibrand" required>
            </li>
            <li>
                <label for="icategory">Category : </label>
                <input type="text" name="icategory" id="icategory" required>
            </li>
            <li>
                <label for="iseller">Seller's Name : </label>
                <input type="text" name="iseller" id="iseller" required>
            </li>
            <li>
                <label for="iprice">Price : </label>
                <input type="number" name="iprice" id="iprice" required>
            </li>
            <li>
                <label for="iimage">Product Image : </label>
                <input type="text" name="iimage" id="iimage" required>
            </li>

            <br>
            <button type="submit" name="isubmit">Add Product</button>
        </ul>
    </form>
    
</body>
</html>