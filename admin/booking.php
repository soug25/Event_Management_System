<<<<<<< HEAD
<div class="container-fluid">
	<form action="" id="manage-book">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id :'' ?>">
		<input type="hidden" name="venue_id" value="<?php echo isset($_GET['venue_id']) ? $_GET['venue_id'] :'' ?>">
		<div class="form-group">
			<label for="" class="control-label">Full Name</label>
			<input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Address</label>
			<textarea cols="30" rows = "2" required="" name="address" class="form-control"><?php echo isset($address) ? $address :'' ?></textarea>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Email</label>
			<input type="email" class="form-control" name="email"  value="<?php echo isset($email) ? $email :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Contact #</label>
			<input type="text" class="form-control" name="contact"  value="<?php echo isset($contact) ? $contact :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Duration</label>
			<input type="text" class="form-control" name="duration"  value="<?php echo isset($duration) ? $duration :'' ?>" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Desired Event Schedule</label>
			<input type="text" class="form-control datetimepicker" name="schedule"  value="<?php echo isset($schedule) ? $schedule :'' ?>" required>
		</div>
	</form>
</div>
<script>
	 $('.datetimepicker').datetimepicker({
	      format:'Y/m/d H:i',
	      startDate: '+3d'
	  })
	$('#manage-book').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'admin/ajax.php?action=save_book',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("book Request Sent.",'success')
						end_load()
						uni_modal("","book_msg.php")

				}
			}
		})
	})
=======
<?php include('db_connect.php');?>

<div class="container-fluid">
<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.5); /* IE */
  -moz-transform: scale(1.5); /* FF */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -o-transform: scale(1.5); /* Opera */
  transform: scale(1.5);
  padding: 10px;
}
</style>
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Venue Booking List</b>
						<span class="">

							<button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" type="button" id="new_book">
					<i class="fa fa-plus"></i> New</button>
				</span>
					</div>
					<div class="card-body">
						
						<table class="table table-bordered table-condensed table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Booking Information</th>
									<th class="">Customer Information</th>
									<th class="">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$booking = $conn->query("SELECT b.*,v.venue from venue_booking b inner join venue v on v.id = b.venue_id");
								while($row=$booking->fetch_assoc()):
									
								?>
								<tr>
									
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										 <p>Venue: <b><?php echo ucwords($row['venue']) ?></b></p>
										 <p><small>Schedule: <b><?php echo date("M d,Y h:i A",strtotime($row['datetime'])) ?></b></small></p>
										 <p><small>Duration: <?php echo ucwords($row['duration']) ?></small></p>
									</td>
									<td class="">
										 <p>Booked by: <b><?php echo  ucwords($row['name']) ?></b></p>
										 <p><small>Email: <b><?php echo  ucwords($row['email']) ?></b></small></p>
										 <p><small>Contact: <b><?php echo  ucwords($row['contact']) ?></b></small></p>
										 <p><small>Address: <b><?php echo  ucwords($row['address']) ?></b></small></p>
									</td>
									<td class="text-center">
										 <?php if($row['status'] == 0): ?>
										 	<span class="badge badge-secondary">For Verification</span>
										 <?php elseif($row['status'] == 1): ?>
										 	<span class="badge badge-primary">Confirmed</span>
										<?php elseif($row['status'] == 2): ?>
										 	<span class="badge badge-danger">Cancelled</span>
										 <?php endif; ?>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_book" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										<?php if(in_array($row['status'],array(0,2))): ?>
										<button class="btn btn-sm btn-outline-danger delete_book" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										 <?php endif; ?>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('#new_book').click(function(){
		uni_modal("New Entry","manage_booking.php")
	})
	
	$('.edit_book').click(function(){
		uni_modal("Manage Book Details","manage_booking.php?id="+$(this).attr('data-id'))
		
	})
	$('.delete_book').click(function(){
		_conf("Are you sure to delete this Person?","delete_book",[$(this).attr('data-id')])
	})

	function delete_book($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_book',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
>>>>>>> 2af2802 (Initial commit)
</script>