<?php
require 'connection.php';
session_start();
if(!isset($_SESSION['rid']))
{
	header('location:login.php');
}
else {
	if(isset($_POST['add'])){
		$rid=$_SESSION['rid'];
		$bg=$_POST['bg'];
		$num=$_POST['num'];
		$date=strtotime($_POST['date']);
		$date=date('Y-m-d', $date);
		$wt=$_POST['wt'];
		$age=$_POST['age'];
		$check_data = mysqli_query($conn, "SELECT rid FROM blooddinfo where rid='$rid' && bg='$bg'&&stock='$num'&& doa='$date'");
		if(mysqli_num_rows($check_data) > 0){
			$error= 'You have already added this blood sample.';
			header( "location:../blooddinfo.php?error=".$error );
}
elseif($wt<50||$age<18){
	$error= 'You are not eligible for donation.';
	header( "location:../blooddinfo.php?error=".$error );
}
else{
		$sql = "INSERT INTO blooddinfo (bg, rid,stock,doa) VALUES ('$bg', '$rid','$num','$date')";
		if ($conn->query($sql) === TRUE) {
			$msg = "You have added record successfully.";
			header( "location:../blooddinfo.php?msg=".$msg );
		} else {
			$error = "Error: " . $sql . "<br>" . $conn->error;
            header( "location:../blooddinfo.php?error=".$error );
		}
		$conn->close();
	}
}
}
?>