<?php 
    $dbConn = mysqli_connect("localhost", "root", "", "phplearn");

    function doQuery($query) {
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
?>