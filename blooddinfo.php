<?php
require 'file/connection.php';
session_start();
if (!isset($_SESSION['rid'])) {
    header('location:login.php');
} else {
?>
<!DOCTYPE html>
<html>
<?php $title = "Bloodbank | Add blood samples"; ?>
<?php require 'head.php'; ?>
<style>
    /* Styles for the background and form layout */
    body {
        background: url(image/p2.png) no-repeat center;
        background-size: cover;
        min-height: 0;
        height: 100%;
    }

    .login-form {
        width: calc(100% - 20px);
        max-height: 650px;
        max-width: 450px;
        background-color: white;
    }

    /* Set table properties */
    table {
        border-collapse: collapse;
        border: 1px solid black;
        color: black;
        width: 100%;
        border-radius: 5px;
        -moz-border-radius: 5px !important;
    }

    /* Style table headers */
    th {
        background-color: #49c5b6;
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        width: 10%;
        margin-bottom: 10px;
    }

    /* Style table rows */
    tr {
        border: 1px solid #ddd;
        width: 10%;
    }

    /* Add hover effect on table rows */
    tr:hover {
        background-color: #D14836;
        color: white;
        transform: scale(1.01);
    }
</style>
<body>
    <?php require 'header.php'; ?>
    <div class="container cont">
        <?php require 'message.php'; ?>
        <div class="row justify-content-center">
            <!-- Form to add blood group available -->
            <div class="col-lg-4 col-md-5 col-sm-6 col-xs-7 mb-5">
                <div class="card">
                    <div class="card-header title">Add blood group available in your known community</div>
                    <div class="card-body">
                        <form action="file/infoAddd.php" method="post">
                            <label>Weight (in Kgs):</label>
                            <input type="number" name="wt" min="0" max="700"><br>
                            <label>Age (in yr):</label>
                            <input type="number" name="age" min="0" max="700"><br>
                            <div style="display:flex; align-items:center; gap: 20px;">
                                <label>Blood type:</label>
                                <select class="form-control" name="bg" required="" style="width: 25%;">
                                    <option>A-</option>
                                    <option>A+</option>
                                    <option>B-</option>
                                    <option>B+</option>
                                    <option>AB-</option>
                                    <option>AB+</option>
                                    <option>O-</option>
                                    <option>O+</option>
                                </select>
                            </div><br>
                            <label>Units of blood:</label>
                            <input type="number" name="num" min="0" max="700"><br>
                            <label>Date of availability:</label>
                            <input type="date" name="date" id="Test_DatetimeLocal"><br><br>
                            <label>Have you donated blood recently?</label>
                            <div>
                                <input type="radio" name="donated_recently" value="yes" required> Yes<br>
                                <input type="radio" name="donated_recently" value="no" required> No<br>
                            </div>
                            <!-- Add a container for the Date of last blood donation input -->
                            <div class="last-donation-date-container" style="display:none;">
                                <label>Date of last blood donation:</label>
                                <input type="date" name="last_donation_date" id="last_donation_date">
                            </div>
                            <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" title="click to see">Term & conditions.</a><br>
                            <div class="collapse" id="collapseExample">
                                If you or your Friends/Family have the mentioned(below) blood then only add Blood group(No spam). So, that the hospital can contact you with your given details if they are in need of you or your friends/family blood. You should have a blood sample tested by your doctor’s, nurse, or trained phlebotomist, at a pathology collection centre, clinic, or hospital. Blood samples are most commonly taken from the inside of the elbow where the veins are usually closer to the surface. Make sure you have been eating a healthy diet (No Smoking/Drinking) at least for a week before you have decided to donate Blood. By clicking the tick mark, you are promising that you have read and accepted the above instructions and also willing to donate blood voluntarily.<br><br>
                            </div>
                            <input type="checkbox" name="condition" value="agree" required> Agree<br><br>
                            <input type="submit" name="add" value="Add" class="btn btn-primary btn-block"><br>
                            <a href="Userpage.html" class="float-right" title="click here">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Display added blood group information -->
            <?php
            if (isset($_SESSION['rid'])) {
                $rid = $_SESSION['rid'];
                $sql = "SELECT * from blooddinfo where rid='$rid'";
                $result = mysqli_query($conn, $sql);
            }
            ?>
            <div class="col-lg-4 col-md-5 col-sm-6 col-xs-7 mb-5">
                <table bgcolor="#2779a7">
                    <th colspan="6" class="title">User</th>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Blood Group</th>
                        <th>Blood stock</th>
                        <th>Blood availability</th>
                        <th>Action</th>
                        <th>Blood Units</th>
                        <th>Date of availability</th>
                    </tr>
                    <div>
                        <?php
                        if ($result) {
                            $row = mysqli_num_rows($result);
                            if ($row) {
                                //echo "<b> Total ".$row." </b>";
                            } else {
                                echo '<b style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;">Nothing to show.</b>';
                            }
                        }
                        ?>
                    </div>
                    <?php
                    $counter = 0;
                    while ($row = mysqli_fetch_array($result)) {
                        $counter++;
                    ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
                            <td><?php echo $row['bg']; ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td><?php echo $row['doa']; ?></td>
                            <td><a href="file/deleted.php?bdid=<?php echo $row['bdid']; ?>" class="btn btn-danger">Delete</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the last_donation_date input element
        const lastDonationDateInput = document.getElementById('last_donation_date');

        // Get the container for the Date of last blood donation input
        const lastDonationDateContainer = document.querySelector('.last-donation-date-container');

        // Add an event listener to the "Have you donated blood recently?" radio buttons
        const donatedRecentlyInputs = document.querySelectorAll('input[name="donated_recently"]');
        donatedRecentlyInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                // Check if the "No" option is selected
                if (input.value === 'yes') {
                    // Show the Date of last blood donation input
                    lastDonationDateContainer.style.display = 'block';
                } else {
                    // Hide the Date of last blood donation input
                    lastDonationDateContainer.style.display = 'none';
                }
            });
        });

        // Add an event listener to the form submission
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            const lastDonationDateValue = new Date(lastDonationDateInput.value);
            const sixMonthsAgo = new Date();
            sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 6);

            // Check if the "Yes" option is selected and last_donation_date is valid
            const donatedRecentlyInput = document.querySelector('input[name="donated_recently"]:checked');
            if (donatedRecentlyInput && donatedRecentlyInput.value === "yes" && lastDonationDateValue > sixMonthsAgo) {
                // Prevent form submission and show an error message
                event.preventDefault();
                alert('You are not eligible to donate blood. You should have donated blood at least 6 months ago.');
            }
        });
    });
</script>
<?php } ?>
