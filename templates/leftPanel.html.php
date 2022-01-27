<?php
require '../db.php';

$carNames = new \entry\DatabaseTable($pdo, 'manufacturers', 'id');

$cars = $carNames->findAll();  

echo '<section class="left">';
echo '<ul>';
foreach($cars as $car)
{
   
    echo '<li><a href=/manus/list?manufacturerId='.$car['id'].'>'.$car['name'].'</a></li>';

}
echo '</ul>';
echo '</section>';

?>
