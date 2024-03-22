<?php
session_start(); 
require 'connection.php';
if(!isset($_SESSION['hid']))
{
	header('location:../login.php');
}
else {
	if(isset($_POST['request'])){
		$rid = $_POST['rid'];
		$hid = $_SESSION['hid'];
		$bg = $_POST['bg'];
		$num = $_POST['num'];
		$doa = $_POST['date'];
		$check_data = mysqli_query($conn, "SELECT donoid FROM blooddonate where rid='$rid' and hid='$hid'and stock='$num' and doa='$doa'");
		if(mysqli_num_rows($check_data) > 0){
		$sql="INSERT INTO blooddonate (bg, rid, hid,stock,doa) VALUES ('$bg', '$rid', '$hid','$num','$doa')";
		if ($conn->query($sql) === TRUE) {
			$msg = 'You have requested '.$num.' unit of blood group '.$bg.'.For the updation of your request you can check your Status now.';
			header( "location:../deleteit.php?msg=".$msg);
		} else {
			$error = "Error: " . $sql . "<br>" . $conn->error;
            header( "location:../deleteit.php?error=".$error );
		}
}else{
		$sql="INSERT INTO blooddonate (bg, rid, hid,stock,doa) VALUES ('$bg', '$rid', '$hid','$num','$doa')";
		if ($conn->query($sql) === TRUE) {
			$msg = 'You have requested '.$num.'unit of blood group '.$bg.'.For the updation of your request you can check your Status now.';
			header( "location:../deleteit.php?msg=".$msg);
		} else {
			$error = "Error: " . $sql . "<br>" . $conn->error;
            header( "location:../deleteit.php?error=".$error );
		}
		$conn->close();
	}
}
}
?>