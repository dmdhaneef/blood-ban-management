<?php
session_start(); 
require 'connection.php';
if(!isset($_SESSION['rid']))
{
	header('location:../login.php');
}
else {
	if(isset($_POST['request'])){
		$hid = $_POST['hid'];
		$rid = $_SESSION['rid'];
		$bg = $_POST['bg'];
		$num = $_POST['num'];
		$doa = $_POST['date'];
		
		$check_data = mysqli_query($conn, "SELECT reqid FROM bloodrequest where hid='$hid' and rid='$rid' and stock='$num' and doa='$doa'");
		if(mysqli_num_rows($check_data) > 0){
		$sql="INSERT INTO bloodrequest (bg, hid, rid,stock,doa) VALUES ('$bg', '$hid', '$rid','$num','$doa')";
		if ($conn->query($sql) === TRUE) {
			$msg = 'You have requested'.$num.'units of blood group '.$bg.'.For the updation of your request you can check your Status now.';
			header( "location:../abs.php?msg=".$msg);
		} else {
			$error = "Error: " . $sql . "<br>" . $conn->error;
            header( "location:../abs.php?error=".$error );
		}
}else{
		$sql="INSERT INTO bloodrequest (bg, hid, rid,stock,doa) VALUES ('$bg', '$hid', '$rid','$num','$doa')";
		if ($conn->query($sql) === TRUE) {
			$msg = 'You have requested '.$num.'  units of blood group '.$bg.'.For the updation of your request you can check your Status now.';
			header( "location:../abs.php?msg=".$msg);
		} else {
			$error = "Error: " . $sql . "<br>" . $conn->error;
            header( "location:../abs.php?error=".$error );
		}
		$conn->close();
	}
}
}
?>