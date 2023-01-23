<?php
    require '../functions.php';

    $eId = $_GET["id"];
    $product = getProductsByQuery("SELECT * FROM products WHERE id = $eId")[0];

    if (isset($_POST["esubmit"])) {
        $check = editProduct($_POST, $_FILES);
        if ($check > 0) {
            echo "
                <script>
                    alert('Succesfully edited the product!');
                    document.location.href = '../index.php';
                </script>
            ";
        } else if ($check !== 0) {
            echo "
                <script>
                    alert('Failed editing the product..');
                    document.location.href = '../index.php';
                </script>
            ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>
<body>
    <a href="../index.php">← Go Back</a>
    <br>

    <h1>Editing a Product</h1>

    <form method="post" enctype="multipart/form-data">
        <ul>
            <input type="hidden" name="eid" id="eid" value="<?= $product["id"] ?>">
            <input type="hidden" name="oldimg" id="oldimg" value="<?= $product["image"] ?>">
            <li>
                <label for="ename">Product Name : </label>
                <input type="text" name="ename" id="ename" value="<?= $product["name"] ?>" required>
            </li>
            <li>
                <label for="ebrand">Brand : </label>
                <input type="text" name="ebrand" id="ebrand" value="<?= $product["brand"] ?>" required>
            </li>
            <li>
                <label for="ecategory">Category : </label>
                <input type="text" name="ecategory" id="ecategory" value="<?= $product["category"] ?>" required>
            </li>
            <li>
                <label for="eseller">Seller's Name : </label>
                <input type="text" name="eseller" id="eseller" value="<?= $product["seller"] ?>" required>
            </li>
            <li>
                <label for="eprice">Price : </label>
                <input type="number" name="eprice" id="eprice" value="<?= $product["price"] ?>" required>
            </li>
            <li>
                <label for="eimage">Product Image : </label><br>
                <img src="../../img/<?= $product["image"] ?>" width="100" height="100"><br>
                <input type="file" name="eimage" id="eimage">
            </li>

            <br>
            <button type="submit" name="esubmit">Edit Product</button>
        </ul>
    </form>
    
</body>
</html>