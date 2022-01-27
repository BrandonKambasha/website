<a class="new" href="/showroom/add">Add new car</a>

    <table>
    <thead>
    <tr>
    <th>Model</th>
    <th style="width: 10%">Price</th>
    <th style="width: 5%">&nbsp;</th>
    <th style="width: 5%">&nbsp;</th>
    <th style="width: 5%">&nbsp;</th>
    </tr>

    <?php
        /* require '../templates/database.php';
      
        $carsTable = new DatabaseTable ($pdo,'cars','id');
        $cars = $carsTable->findAll(); */

			foreach ($cars as $car) {
				echo '<tr>';
				echo '<td>' . $car['name'] . '</td>';
				echo '<td>£' . $car['price'] . '</td>';
                echo '<td><a style="float: right" href="/showroom/archive?id=' . $car['id'] . '">Archive</a></td>';
				echo '<td><a style="float: right" href="/showroom/edit?id=' . $car['id'] . '">Edit</a></td>';
				echo '<td><form method="post" action="/showroom/delete">
				<input type="hidden" name="id" value="' . $car['id'] . '" />
				<input type="submit" name="submit" value="Delete" />
				</form></td>';
				echo '</tr>';
			}
        ?>
			</thead>
			</table>