<?php 
    require 'functions.php';

    $dId = $_GET['id'];

    if (delProduct($dId) > 0) {
        echo "
            <script>
                alert('Succesfully deleted the product!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Failed deleting the product..');
                document.location.href = 'index.php';
            </script>
        ";
    }

?>