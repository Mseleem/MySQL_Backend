

<?php

include("header.php");

$userObject = new users;
$totCount = $userObject->count();
echo $totCount;

echo '<br>';
$productObject = new users;
$prodCount = $productObject->count();
echo $prodCount;

include("footer.php");

?>