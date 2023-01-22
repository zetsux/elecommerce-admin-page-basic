<?php 
    $dbConn = mysqli_connect("localhost", "root", "", "phplearn");

    function getProductsByQuery($query) {
        global $dbConn;

        $res = mysqli_query($dbConn, $query);
        $rows = [];

        while ($r = mysqli_fetch_assoc($res)) {
            $rows[] = $r;
        }

        return $rows;
    }

    function addProduct($newData) {
        global $dbConn;

        $iname = htmlspecialchars($newData["iname"]);
        $ibrand = htmlspecialchars($newData["ibrand"]);
        $icategory = htmlspecialchars($newData["icategory"]);
        $iprice = htmlspecialchars($newData["iprice"]);
        $iseller = htmlspecialchars($newData["iseller"]);
        $iimage = htmlspecialchars($newData["iimage"]);

        $query = 
            "INSERT INTO products VALUES (
                '', '$iname', '$ibrand', '$icategory', '$iseller', $iprice, '$iimage')";

        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }

    function delProduct($dId) {
        global $dbConn;

        $query = "DELETE FROM products WHERE id = $dId";
        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }

    function editProduct($newData) {
        global $dbConn;

        $eid = $newData["eid"];
        $ename = htmlspecialchars($newData["ename"]);
        $ebrand = htmlspecialchars($newData["ebrand"]);
        $ecategory = htmlspecialchars($newData["ecategory"]);
        $eprice = htmlspecialchars($newData["eprice"]);
        $eseller = htmlspecialchars($newData["eseller"]);
        $eimage = htmlspecialchars($newData["eimage"]);

        $query = 
            "UPDATE products SET 
                name = '$ename',
                brand = '$ebrand',
                category = '$ecategory',
                seller = '$eseller',
                price = $eprice,
                image = '$eimage'
            WHERE id = $eid
            ";

        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }
?>