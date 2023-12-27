<?php
$list=array(1, 2, 3, 4, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontrollflüsse</title>
</head>
<body>
    <h1> Kontrollflüsse</h1>
<?php
var_dump($list);
foreach($list as $value) {
    echo "<p>" . $value . "</p>";
    }
?> 

<?php
foreach($list as $value) {
?>
<p><?php echo $value; ?></p>
<?php
}
?>

<?php foreach($list as $value) { ?>
<p><?= $value; ?></p>
<?php } ?>

</body>
</html>