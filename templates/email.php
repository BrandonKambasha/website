
<form action="" method="POST" enctype="multipart/form-data">

				<input type="hidden" name="id" value="<?php echo $car['id']; ?>" />
				<label>Name</label>
				<input type="text" name="name" readonly value="<?php echo $car['name']; ?>" />

				<label>Enquiry</label>
				<textarea name="enquiry" readonly><?php echo $car['enquiry']; ?></textarea>
                <label><a href = "mailto:<?php echo $car['email']; ?>">Send Email</a></label>

                </select>

				<label>Complete</label>

				<select name="complete">
                   <option value = 'YES'>Yes</option>
                   <option value = 'NO'>No</option>
                </select>  

                <input type="submit" name="submit" value="Finish" />
</form>