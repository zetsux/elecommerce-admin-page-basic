<?php 
    session_start();

    if (!isset($_SESSION['loggedin'])){
        header('Location: login.php');
        exit;
    }

    require 'functions.php';

    $productPerPage = 5;
    $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
    $firstIndex = ($currentPage-1)*$productPerPage;

    if (isset($_GET["search"])){
        $productTotal = count(searchProducts($_GET["search"], -1, -1));
    } else {
        $productTotal = count(getProductsByQuery("SELECT * FROM products"));
    }
    
    $pageCount = ceil($productTotal/$productPerPage);
    
    if (isset($_GET["search"])){
        $products = searchProducts($_GET["search"], $firstIndex, $productPerPage);
    } else {
        $products = getProductsByQuery("SELECT * FROM products ORDER BY id ASC LIMIT $firstIndex, $productPerPage");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elecommerce Admin Page</title>
</head>
<body>
    <h1 style="display: inline-block; position: relative; bottom: 20px;">Elecommerce Products List</h1>

    <a href="logout.php" style="float: right">Log Out</a>
    <br>

    <a href="product/insert.php" style="display: inline-block">Add Product</a>

    <form method="get" style="float: right">
        <input type="text" name="search" size="30" 
            placeholder="Insert search keyword" autofocus autocomplete="off">
        <button type="submit">Search</button>
    </form>
    
    <hr>

    <div style="text-align: center; align-items: center;">
        <h2 style="font-size: 22px">Page <?= $currentPage ?> of <?= $pageCount ?></h2>

        <?php if ($currentPage > 1) :?>
            <a style="padding: 0px 4px;" 
                href="<?= ((isset($_GET["search"]) && $_GET["search"] !== '') 
                            ? ('?search=' . $_GET["search"] . '&') 
                            : '?') ?>page=<?= $currentPage - 1 ?>">
                    ←
            </a>
        <?php endif; ?>

        <?php for($i = 1; $i <= $pageCount; $i++) : ?>
            <a style="padding: 0px 4px;"
                href="<?= ((isset($_GET["search"]) && $_GET["search"] !== '') 
                            ? ('?search=' . $_GET["search"] . '&') 
                            : '?') ?>page=<?= $i ?>">
                    <?= $i ?> 
            </a>
        <?php endfor; ?>
        
        <?php if ($currentPage < $pageCount) :?>
            <a style="padding: 0px 4px;"
                href="<?= ((isset($_GET["search"]) && $_GET["search"] !== '') 
                            ? ('?search=' . $_GET["search"] . '&') 
                            : '?') ?>page=<?= $currentPage + 1 ?>">
                    →
            </a>
        <?php endif; ?>


        <br><hr>

        <table border="1" cellpadding="10" cellspacing="0" style="margin-left: auto; margin-right: auto;">
            <tr>
                <th>No. </th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Price</th>
                <th>Seller's Name</th>
                <th>Action</th>
            </tr>

            <?php $i = 1 ?>
            <?php foreach($products as $p) :?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <img src="../img/<?= $p['image'] ?>" width="50" height="50">
                    </td>
                    <td><?= $p['name'] ?></td>
                    <td><?= $p['brand'] ?></td>
                    <td><?= $p['category'] ?></td>
                    <td>Rp <?= $p['price'] ?></td>
                    <td><?= $p['seller'] ?></td>
                    <td>
                        <a href="product/update.php?id=<?= $p["id"] ?>">Edit</a> |
                        <a href="product/delete.php?id=<?= $p["id"] ?>" 
                            onclick="return confirm('Are you sure you want to delete this product?')">
                                Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    
</body>
</html>