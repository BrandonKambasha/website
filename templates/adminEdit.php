<form action="" method="POST" enctype="multipart/form-data">

				<input type="hidden" name="id" value="<?php echo $car['id']; ?>" />
				<label>Name</label>
				<input type="text" name="name" value="<?php echo $car['name']; ?>" />

				<label>Description</label>
				<textarea name="description"><?php echo $car['description']; ?></textarea>

				<label>Price</label>
				<input type="text" name="price" value="<?php echo $car['price']; ?>" />

				<label>Mileage</label>
                <input type="text" name="mileage" value ="<?php echo $car['mileage']; ?>" />
                
                <label>Fuel Type</label>

                <select name = "engine">

                <?php
					
							echo '<option selected="selected" value="' . $car['engine'] . '">' . $car['engine'] . '</option>';
						
							if($car['engine']=='petrol')
							{
								echo '<option value="Diesel">Diesel</option>';
							}
							else
							{
								echo '<option value="Petrol">Petrol</option>';
							}
							 
							
						
						
					
				?>

                </select>

				<label>Category</label>

				<select name="manufacturerId">
				<?php
                    
				
					foreach ($stmt as $row) {
						if ($car['manufacturerId'] == $row['id']) {
							echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
						}
						else {
							echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';	
						}
						
					}

				?>

				</select>

				
				<?php
					$path = glob('images/cars/' . $car['id']."_*.jpg");
					
					foreach($path as $car=>$value)
					{
						?>
							<img src="/<?php echo $value?>"/>
						<?php
					}
					
				?>
				<label>Product image</label>

				<input type="file" name="file[]" />

				<input type="submit" name="submit" value="Save Product" />

			</form>
