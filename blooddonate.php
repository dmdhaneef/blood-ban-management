<?php 
require 'file/connection.php'; 
session_start();
  if(!isset($_SESSION['rid']))
  {
  header('location:login.php');
  }
  else {
    $rid = $_SESSION['rid'];
    $sql = "SELECT blooddonate.*, hospitals.* from blooddonate, hospitals where rid='$rid' && blooddonate.hid=hospitals.id";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<style>
    body{
    background: url(image/p4.jpg) no-repeat center;
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
.footer {​​
position: fixed;
left: 0;
bottom: 0;
width: 100%;
background-color: white;
color: black;
text-align: center;
} 
​​/* Set table properties */
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
<?php $title="Bloodbank | Blood Donate"; ?>
<?php require 'head.php'; ?>
<body>
	<?php require 'header.php'; ?>
	<div class="container cont">

		<?php require 'message.php'; ?>

	<!-- <table class="table table-responsive table-striped rounded mb-5"> -->
	<table bgcolor="#2779a7">	

	<tr><th colspan="11" class="title">Blood Donate</th></tr>
		<tr>
			<th>Sr.No.</th>
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
			<td><?php echo $row['hname'];?></td>
			<td><?php echo $row['hemail'];?></td>
			<td><?php echo $row['hcity'];?></td>
			<td><?php echo $row['hphone'];?></td>
			<td><?php echo $row['bg'];?></td>
      <td><?php echo $row['stock']; ?></td>
      <td><?php echo $row['doa']; ?></td>   
      <?php $flag_accept=0;?>   
<td><?php echo 'You have '.$row['status'];?></td>
			<td><?php if($row['status'] == 'Accepted'){ 
        $flag_accept=1;
        $hid1=$row['hid'];
        $rid1=$row['rid'];
        $bg1=$row['bg'];
        $stock1=$row['stock'];
        $doa1=$row['doa'];
        
        $result2=mysqli_query($conn,"  DELETE FROM `blooddinfo` WHERE `rid` ='$rid1'AND `bg`='$bg1' AND `stock` ='$stock1' AND `doa` LIKE '$doa1' ");
        $result3=mysqli_query($conn,"INSERT INTO `bloodinfo` (`hid`, `bg`, `stock`, `doa`) VALUES ('$hid1', '$bg1', '$stock1', '$doa1');");
        ?> <a href="" class="btn btn-success disabled">Accepted</a> <?php }
			else{ ?>
				<a href="file/acceptd.php?donoid=<?php echo $row['donoid'];?>" class="btn btn-success">Accept</a>
			<?php } ?>
			</td>
			<td><?php if($row['status'] == 'Rejected'){ ?> <a href="" class="btn btn-danger disabled">Rejected</a> <?php }
      elseif($flag_accept==1){ ?> <a href="" class="btn btn-danger disabled">Reject</a> <?php }
			else{ ?>
				<a href="file/rejectd.php?donoid=<?php echo $row['donoid'];?>" class="btn btn-danger">Reject</a>
			<?php } ?>
			</td>
			
		</tr>
		<?php } ?>
	</table>

</div>

</body>
</html>
<?php } ?>