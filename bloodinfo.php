<?php 
  require 'file/connection.php';
  session_start();
  if(!isset($_SESSION['hid']))
  {
  header('location:login.php');
  }
  else {
?>
<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Add blood samples"; ?>
<?php require 'head.php'; ?>
<style>
    body{
    background: url(image/p1.jpg) no-repeat center;
    background-size: cover;
    min-height: 0;
    height: 100%;
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

      <div class="row justify-content-center">
          
         <div class="col-lg-4 col-md-5 col-sm-6 col-xs-7 mb-5">
          <div class="card">
            <div class="card-header title">Add blood group available in your hospital</div>
        <div class="card-body">
        <form action="file/infoAdd.php" method="post">

          <div style="display:flex; align-items:center; gap: 20px;">
          <label>Blood Group (Type):&nbsp&nbsp&nbsp</label>
          <select name="bg" required="" style="width: 25% ;height: 30px;">
                
                <option>A-</option>
                <option>A+</option>
                <option>B-</option>
                <option>B+</option>
                <option>AB-</option>
                <option>AB+</option>
                <option>O-</option>
                <option>O+</option>
          </select>
          </div>
        
          <div style="display:flex; align-items:left;gap: 20px; ">
          <label>Units of blood available:</label>
          <input type="number" name="num" min="0" max="700" style="width: 24%; height: 30px">
          </div>          
   
          <label>Date of availability :</label>
          <input type="date" name="date" id="Test_DatetimeLocal"><br>
          <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" title="click to see">Term & conditions. </a><br>
          <div class="collapse" id="collapseExample">
          If you have a blood sample tested by  your doctor’s, nurse, or trained phlebotomist , at a pathology collection centre, clinic or hospital. Blood samples are most commonly taken from the inside of the elbow where the veins are usually closer to the surface. If before the needle is inserted, the area had been cleaned with an antiseptic cloth and blood sample is transferred into tubes containing the correct preservatives then add your blood group available in your hospital to your blood bank.<br><br>
        </div>
          <input type="checkbox" name="condition" value="agree" required> Agree<br><br>          
          <input type="submit" name="add" value="Add" class="btn btn-primary btn-block"><br>
          <a href="hospitalpage.html" class="text-centre" >Cancel</a><br>
        </form>
         </div>
       </div>
     </div>

<?php   if(isset($_SESSION['hid'])){
    $hid=$_SESSION['hid'];
    $sql = "select * from bloodinfo where hid='$hid'";
    $result = mysqli_query($conn, $sql);
  }
  ?>
    <div class="col-lg-4 col-md-5 col-sm-6 col-xs-7 mb-5">
          <!-- <table class="table table-striped table-responsive"> -->
          <table bgcolor="#2779a7">  
          <th colspan="4" class="title">Blood Bank</th>
            <tr>
              <th>Sr.No.</th>
              <th>Blood Samples</th>
              <th>Action</th>
            </tr>
            <div>
                <?php
                if ($result) {
                    $row =mysqli_num_rows( $result);
                    if ($row) { //echo "<b> Total ".$row." </b>";
                }else echo '<b style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;">Nothing to show.</b>';
            }
            ?>
            </div>
            <?php while($row = mysqli_fetch_array($result)) { ?>
            <tr>
              <td><?php echo ++$counter; ?></td>
              <td><?php echo $row['bg'];?></td>
              <td><?php echo $row['stock']; ?></td>
              <td><?php echo $row['doa']; ?></td>
              <td><a href="file/delete.php?bid=<?php echo $row['bid'];?>" class="btn btn-danger">Delete</a></td>
            </tr>
            <?php } ?>
          </table>
      </div>

   </div>
</div>

</body>
<?php } ?>