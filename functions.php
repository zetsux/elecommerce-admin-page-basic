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

    function addProduct($newData, $newFile) {
        global $dbConn;

        $iname = htmlspecialchars($newData["iname"]);
        $ibrand = htmlspecialchars($newData["ibrand"]);
        $icategory = htmlspecialchars($newData["icategory"]);
        $iprice = htmlspecialchars($newData["iprice"]);
        $iseller = htmlspecialchars($newData["iseller"]);

        $iimage = uploadFile($newFile["iimage"], ['jpg', 'png', 'jpeg'], 2000000);
        if (!$iimage) {
            return 0;
        }

        $query = 
            "INSERT INTO products VALUES (
                '', '$iname', '$ibrand', '$icategory', '$iseller', $iprice, '$iimage')";

        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }

    function uploadFile($file, $allowedExtensions, $maxSize) {
        $fileName = $file["name"];
        $fileSize = $file["size"];
        $fileTmp = $file["tmp_name"];

        $fileExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($fileExtension));

        $allowedEString = implode(", ", $allowedExtensions);
        if ( !in_array($fileExtension, $allowedExtensions) ) {
            echo "
                <script>
                    alert('Please upload a file with extension $allowedEString.');
                </script>
            ";
            return false;
        }

        if ( $fileSize > $maxSize ) {
            echo "
                <script>
                    alert('File size is too large, maximum allowed size is $maxSize byte(s).');
                </script>
            ";
            return false;
        }

        $fileName = str_replace("." . $fileExtension, "", $fileName);
        $fileName = substr($fileName, 0, 75) . uniqid() . '.' . $fileExtension;

        move_uploaded_file($fileTmp, '../../img/' . $fileName);
        return $fileName;
    }

    function delProduct($dId) {
        global $dbConn;

        $query = "DELETE FROM products WHERE id = $dId";
        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }

    function editProduct($newData, $newFile) {
        global $dbConn;

        $eid = $newData["eid"];
        $ename = htmlspecialchars($newData["ename"]);
        $ebrand = htmlspecialchars($newData["ebrand"]);
        $ecategory = htmlspecialchars($newData["ecategory"]);
        $eprice = htmlspecialchars($newData["eprice"]);
        $eseller = htmlspecialchars($newData["eseller"]);

        $oldimage = htmlspecialchars($newData["oldimg"]);

        if ($newFile['eimage']['error'] === 4) {
            $eimage = $oldimage;
        } else {
            $eimage = uploadFile($newFile['eimage'], ['jpg', 'png', 'jpeg'], 2000000);
            if (!$eimage) {
                return 0;
            }
        }

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

    function searchProducts($searchKey) {
        $query = "SELECT * FROM products WHERE
                    name LIKE '%$searchKey%' OR
                    brand LIKE '%$searchKey%' OR
                    category LIKE '%$searchKey%' OR
                    seller LIKE '%$searchKey%' OR
                    price LIKE '%$searchKey%'
                 ";

        return getProductsByQuery($query);
    }

    function registUser($newUser) {
        global $dbConn;

        // No slashes and make it non case-sensitive by converting to lowercase
        $runame = strtolower(stripslashes($newUser["runame"]));
        $rpass = mysqli_real_escape_string($dbConn, $newUser["rpw"]);
        $rconfirmpass = mysqli_real_escape_string($dbConn, $newUser["rpw2"]);

        if (strlen($runame) > 100) {
            echo "
                <script>
                    alert('The username is too long, maximum allowed character is 100.');
                </script>
            ";
            return 0;
        }

        $checkUser = mysqli_query($dbConn, "SELECT username FROM users WHERE username = '$runame'");
        if (mysqli_fetch_assoc($checkUser)) {
            echo "
                <script>
                    alert('The username is already registered, please choose another username.');
                </script>
            ";
            return 0;
        }

        if ($rpass !== $rconfirmpass) {
            echo "
                <script>
                    alert('The password and the confirmation password are different.');
                </script>
            ";
            return 0;
        }

        $rpass = password_hash($rpass, PASSWORD_DEFAULT);
        // $rpass = md5($rpass);

        if (strlen($rpass) > 300) {
            echo "
                <script>
                    alert('The password is too long, please shorten it.');
                </script>
            ";
            return 0;
        }

        $query = 
            "INSERT INTO users VALUES (
                '', '$runame', '$rpass')";

        mysqli_query($dbConn, $query);
        return mysqli_affected_rows($dbConn);
    }
?>