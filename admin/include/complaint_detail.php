<?php

if(isset($_GET['cid'])): 
	$id = $_GET['cid'];
	$query = "SELECT * FROM complaints WHERE complaintNo=$id";
	$complaints = $complaint->get_complaints_by_uid($query);

	

	foreach($complaints as $cmp){
//		$cmp->complaintNo;
	}

	$eng_q = "SELECT * FROM cloud_engineear WHERE id= $cmp->cloud_eng_id";
	$eng = $complaint->get_data($eng_q);
?>
<h4>Complaint Details: </h4>
<table class="table table-bordered table-sm" style="padding:4px!important;">
	<tr>
		<td>Complaint Number:</td>
		<td><?php echo $cmp->complaintNo; ?></td>
		<td>Complainant Name:</td>
		<td>
			<?php 	$cmp->user_id;
					$query = "SELECT * FROM users WHERE uid=$cmp->user_id";
					$user = $complaint->get_data($query);
					
					foreach($user as $u){
						echo $u->full_name;
					}


			 ?>
			 	
			 </td>
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
		<td><p class="text-muted"><?php echo $cmp->department; ?></p></td>


		<td>Complaint Type:</td>
		<td><?php echo $cmp->complaint_type; ?></td>
	</tr>

	<tr>
		<td>Complaint Title:</td>
		<td colspan="5"><?php echo $cmp->complaint_title; ?></td>
	</tr>
	
	<tr>
		<td>Complaint Details:</td>
		<td colspan="5"><?php echo $cmp->complaint_detail; ?></td>
	</tr>

	<?php 
			$query = "SELECT * FROM complaintremark WHERE complaintNo=$cmp->complaintNo";
			$remark = $complaint->get_data($query);
			if(!empty($remark)){
			foreach($remark as $rem): ?>
			<tr>
			<td >Remark:</td>
		<td colspan="5"><?php echo $rem->remark; ?><br><strong>Remark Date:</strong> <?php echo $rem->remarkDate; ?></td>
			</tr>
				<?php
			endforeach;
		}
		?>

	<tr>
		<td>Cloud Engineear:</td>

		<td colspan="5">
			<?php echo (isset($eng[0]->full_name)) ? $eng[0]->full_name :'-';?>
		</tr>
	
	<tr>
		<td>File:</td>

		<td colspan="5">
			<?php if($cmp->complaint_file !=="N/A"){ ?>
			<a href="../user/upload_file/<?php echo $cmp->complaint_file; ?>">View File</a></td>
		<?php }else{
			echo "N/A";
		}?>

	</tr>
	<tr>
		<td>Status:</td>
		<td colspan="5">
			<?php if($cmp->status == null){
							echo "<p class='text-danger'>Not process yet</p>";
						}elseif($cmp->status=='in process'){
							echo "<p class='text-warning'>In process</p>";
						}elseif($cmp->status=='closed'){
							echo "<p class='text-success'>Closed</p>";
						} 
				 ?>
				 	
		 </td>
	</tr>

	<tr>
		<td>Final Status:</td>
		<td colspan="5">
			<?php if($cmp->status == null){
							echo "<p class='text-danger'>Not process yet</p>";
						}elseif($cmp->status=='in process'){
							echo "<p class='text-warning'>In process</p>";
						}elseif($cmp->status=='closed'){
							echo "<p class='text-success'>Closed</p>";
						} 
				 ?>
				 	
				 </td>
	</tr>
	<tr>
		<td>Action: </td>
		<td colspan="5">
		<?php 
			if(isset($eng[0]->id))
			{?>
				<a href="index.php?page=view_eng&uid=<?php echo $eng[0]->id;?>"><button class="btn btn-sm btn-primary">View cloud engineear</button></a>
		<?php	
			}else{
				?>
					<a  href=""><button style="cursor:no-drop" disabled class="btn btn-sm btn-primary">View cloud engineear</button></a>
				<?php
			}
		?>
			
			<a href="index.php?page=view_user&uid=<?php echo $cmp->user_id; ?>"> <button class="btn btn-sm btn-info">View User</button>
		</td>
	</tr>
</table>
<?php endif; ?>