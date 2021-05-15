<?php
include('../../database/config.php');
include('../../database/complaint.php');
$database = new database();
$db = $database->getConnection();
$complaint = new complaint($db);



if(isset($_POST['id'])): 
	$id = $_POST['id'];
	$query = "SELECT * FROM complaints WHERE complaintNo=$id";
	$complaints = $complaint->get_complaints_by_uid($query);
	foreach($complaints as $cmp){
//		$cmp->complaintNo;
	}
	
	
?>
<h4>Complaint Details: </h4>
<table class="table table-b" >
	<tr>
		<td>Complaint Number:</td>
		<td width="40%"><?php echo $cmp->complaintNo; ?></td>

		<td>Regd Date:</td>
		<td><?php echo date('d-m-Y',strtotime($cmp->rgdDate)); ?></td>


	</tr>

	<tr>
		<td>Category:</td>
		<td>
			<?php 	$cmp->category_id;
					$query2 = "SELECT * FROM category WHERE category_id=$cmp->category_id";
					$cate = $complaint->get_data($query2);
					foreach($cate as $cat){
						echo $cat->category_name;
					}


			 ?>
			
		</td>

		<td>Department:</td>
		<td><?php echo $cmp->department; ?></td>


	</tr>

	<tr>
		<td>Complaint Type:</td>
		<td><?php echo $cmp->complaint_type; ?></td>

		<td>File:</td>
		<td><?php echo $cmp->complaint_file; ; ?></td>


	</tr>

	<tr>
		<td>Complaint Title:</td>
		<td><?php echo $cmp->complaint_title; ?></td>
	</tr>
	<tr>
		<td>Complaint Details:</td>
		<td><?php echo $cmp->complaint_detail; ?></td>
	</tr>

	<tr>
		<td>Remark:</td><td>
		<?php 
			$query = "SELECT * FROM complaintremark WHERE complaintNo=$cmp->complaintNo";
			$remark = $complaint->get_data($query);
			if(!empty($remark)){
			foreach($remark as $rem):
				$rem->complaintNo;
				$rem->remark;
				echo "<strong>You : </strong>".$rem->user_remark;?><br><strong>Remark Date:</strong><?php echo $rem->remarkDate."<br>" ;
			echo "<strong>Cloud : </strong>".$rem->remark;?><br><strong>Remark Date:</strong><?php echo $rem->remarkDate."<br>" ;
			endforeach;
		?><br>
		</td>
	</tr>
	<tr>
		<td><b>New Remark  :</b></td>
		<td colspan="5">
		</td>
	</tr>
	<?php } ?>

<tr>
	<table class="table table-dark">
	<form method="post" action="index.php" id="remark_form">
	<tr>
		<td><b>Complaint No: &nbsp;&nbsp;</td>
		<td width=""><input type="text" value="<?php echo $id; ?>" class="form-control" name="id" readonly></b></td>
	</tr>
	<tr>
		<td><b>Remark</b></td>
		<td><textarea rows="7" cols="40" class="form-control" name="remark" required></textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="remark_submit" value="Submit" class="btn btn-sm btn-primary"></td>
	</tr>
	</form>
</table>
</tr>
<!-- Button trigger modal -->

<?php
	if(isset($_POST['remark_submit'])){
		$cid = $_POST['id'];
		$remark = $_POST['remark'];
		$query = "INSERT INTO complaintremark(complaintNo,user_remark)VALUES($cid,'$remark')";
		//$query2 = "UPDATE complaints SET status='$status' WHERE complaintNo=$cid";
		$complaint->executeQuery($query);
		//$complaint->executeQuery($query2);

		echo "Remark is updated successfully";
	}
?>
</tr>
	<tr>
		<td>Status:</td>
		<td>
			<?php if($cmp->status == null){
							echo "<button class='btn btn-sm btn-danger'>Not process yet</button>";
						}elseif($cmp->status=='in process'){
							echo "<button class='btn btn-sm btn-warning'>In process</button>";
						}elseif($cmp->status=='closed'){
							echo "<button class='btn btn-sm btn-success'>Closed</button>";
						}
				 ?>
				 	
		 </td>
	</tr>

	<tr>
		<td>Final Status:</td>
		<td><?php if($cmp->status == null){
							echo "<button class='btn btn-sm btn-danger'>Not process yet</button>";
						}elseif($cmp->status=='in process'){
							echo "<button class='btn btn-sm btn-warning'>In process</button>";
						}elseif($cmp->status=='closed'){
							echo "<button class='btn btn-sm btn-success'>Closed</button>";
						} 
					?></td>
	</tr>

</table>
 

<!-- Modal -->

<?php endif; ?>

<script type="text/javascript">
	$('#remark_submit').click(function(){
		$('#remark_form').submit();
	});
	
</script>