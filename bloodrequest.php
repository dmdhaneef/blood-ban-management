<?php 
require 'file/connection.php'; 
session_start();
  if(!isset($_SESSION['hid']))
  {
  header('location:login.php');
  }
  else {
    $hid = $_SESSION['hid'];
    $sql = "select bloodrequest.*, receivers.* from bloodrequest, receivers where hid='$hid' && bloodrequest.rid=receivers.id";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Blood Requests"; ?>
<?php require 'head.php'; ?>
<style>
    body{
    background: url(image/p2.png) no-repeat center;
    background-size: cover;
    min-height: 0;
    height: 650px;
  }
.login-form{
    width: calc(100% - 20px);
    max-height: 650px;
    max-width: 450px;
    background-color: white;
}
/* Set table properties */
table {
  border-collapse: collapse;
  border:1px solid black;
  color:black;
  width: 100%;
  border-radius: 5px;
  -moz-border-radius: 5px !important;
  
}

/* Style table headers */
th {
  background-color:  #49c5b6;
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
  width:10%;
  margin-bottom: 10px;
}

/* Style table rows */
tr {
  border: 1px solid #ddd;
  width:10%;
}

/* Add hover effect on table rows */
tr:hover {
  background-color: #D14836;
  color:white;
  transform: scale(1.01);


}
</style>
<body>
	<?php require 'header.php'; ?>
	<div class="container cont">

		<?php require 'message.php'; ?>

	<!-- <table class="table table-responsive table-striped rounded mb-5"> -->
	<table bgcolor="#2779a7">	

	<tr><th colspan="11" class="title">Blood requests</th></tr>

		<tr>
			<th>Sr.NO.</th>
			<th>Name</th>
			<th>Email</th>
			<th>City</th>
			<th>Phone</th>
			<th>Blood Group</th>
      <th>Blood stock</th>
      <th>Blood availability</th>       
			<th>Status</th>
			<th colspan="2">Action</th>
		</tr>

		    <div>
                <?php
                if ($result) {
                    $row =mysqli_num_rows( $result);
                    if ($row) { //echo "<b> Total ".$row." </b>";
                }else echo '<b style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;">No one has requested yet. </b>';
            }
            ?>
            </div>

		<?php while($row = mysqli_fetch_array($result)) { ?>

		<tr>
			<td><?php echo ++$counter;?></td>
			<td><?php echo $row['rname'];?></td>
			<td><?php echo $row['remail'];?></td>
			<td><?php echo $row['rcity'];?></td>
			<td><?php echo $row['rphone'];?></td>
			<td><?php echo $row['bg'];?></td>
      <td><?php echo $row['stock']; ?></td>
      <td><?php echo $row['doa']; ?></td>      
			<td><?php echo 'You have '.$row['status'];?></td>
      <?php $flag_accept=0;?>
			<td><?php if($row['status'] == 'Accepted'){ $flag_accept=1;
            $hid1=$row['hid'];
            $bg1=$row['bg'];
            $stock1=$row['stock'];
            $doa1=$row['doa'];
        $result2=mysqli_query($conn,"  DELETE FROM `bloodinfo` WHERE `hid` ='$hid1'AND `bg`='$bg1' AND `stock` ='$stock1' AND `doa` LIKE '$doa1' ");
        ?> <a href="" class="btn btn-success disabled">Accepted</a>
        
      <?php }
			else{ ?>
				<a href="file/accept.php?reqid=<?php echo $row['reqid'];?>" class="btn btn-success">Accept</a>
			<?php } ?>
			</td>
			<td><?php if($row['status'] == 'Rejected'){ ?> <a href="" class="btn btn-danger disabled">Rejected</a> <?php }
		        elseif($flag_accept==1){ ?> <a href="" class="btn btn-danger disabled">Reject</a> <?php }
			else{ ?>
				<a href="file/reject.php?reqid=<?php echo $row['reqid'];?>" class="btn btn-danger">Reject</a>
			<?php } ?>
			</td>
			
		</tr>
		<?php }?>
	</table>
</div>
    
</body>
</html>
<?php } ?>