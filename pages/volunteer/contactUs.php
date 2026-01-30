<?php

    
    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];
    
    $sql_profileDetails = "SELECT * FROM users WHERE user_id = '$userID';";

    $profileDetails = mysqli_fetch_assoc(mysqli_query($conn,$sql_profileDetails));

    $userName = $profileDetails['name']; 
    $userContact = $profileDetails['contact_number']; 
    $userEmail = $profileDetails['education_email'];



    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        include("../../conn.php");
        include("../../backend/utility.php");

        $fullName = trim($_POST["txtFullName"]);
        $email= trim($_POST["txtEmail"]);
        $contactNumber = trim($_POST["txtContactNumber"]);
        $subject = $_POST["txtSubject"];
        $description = trim($_POST["txtDescription"]);

        $submissionID = newID($conn, "contact_submission", "S");
        $todayDateTime = date("Y-m-d H:i:s");

        $sql = "INSERT INTO contact_submission (submission_id, full_name, email_address, contact_number, subject, content, submission_datetime)
                VALUES ('$submissionID', '$fullName', '$email', '$contactNumber', '$subject', '$description', '$todayDateTime')";
        
        if(mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('--- Successfully Submit Contact Request ---\\nYour Request ID: $submissionID\\nOur Team will contact you soon!');
                    window.location.href = 'contactUs.php';
                  </script>";
        }

        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Us</title>

        
        <link rel="stylesheet" href="../../styles/volunteer.css">
        <script src="../../scripts/volunteer.js"></script>
        
        
        <link rel="stylesheet" href="../../styles/guest.css">
        <!-- style & ico -->
        <link rel="icon" href="../../src/elements/logo_vertical.png" type="image/x-icon">

        <!-- icon  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            #contactUs {
                color: #707c68;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <?php include("header.php") ?>

        <div class="profileHead">
        <div>
            <div><a href="about.php" class="backEvent"><i class="fa-solid fa-arrow-left"></i></a> Contact Us</div>
        </div>

        </div>

        <main class="contact-us">
            <div class="contact-us-container">
                <div class="contact-us-header">
                    <h1>Contact Us</h1>
                    <p>Any questions or remarks? Just write us a message!</p>
                </div>

                <div class="contact-us-details">
                    <img src="../../src/elements/contact-us.jpg" alt="" class="contact-us-image">
                    <form action="" method="POST" class="contact-form">
                        <div class="input-box">
                            <label for="fullname">Full Name *</label>
                            <input type="text" name="txtFullName" id="fullname" value="<?php echo$userName ?>">
                            <div class="form-error-text" id="error-fullname">Enter a Valid Name</div>
                        </div>

                        <div class="input-box">
                            <label for="email">Email *</label>
                            <input type="email" name="txtEmail" id="email" value="<?php echo$userEmail ?>">
                            <div class="form-error-text" id="error-email">Enter a Valid Email</div>
                        </div>

                        <div class="input-box">
                            <label for="contactNumber">Contact Number *</label>
                            <input type="text" name="txtContactNumber" id="contactNumber" value="<?php echo$userContact ?>">
                            <div class="form-error-text" id="error-contactNumber">Enter a Valid Contact Number</div>
                        </div>

                        <div class="input-box">
                            <label for="subject">Subject *</label>
                            <select name="txtSubject" id="subject">
                                <option value="">-- Please Select --</option>
                                <option value="Account Registration">Account Registration</option>
                                <option value="Green Points & Rewards">Green Points & Rewards</option>
                                <option value="Partnership & Collaboration">Partnership & Collaboration</option>
                                <option value="Feedback & Suggestions">Feedback & Suggestions</option>
                                <option value="Join the Committee">Join the Committee</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="General Inquiry">General Inquiry</option>
                            </select>
                            <div class="form-error-text" id="error-subject">Select Subject</div>
                        </div>

                        <div class="input-box">
                            <label for="description">Description *</label>
                            <textarea name="txtDescription" id="description"></textarea>
                            <div class="form-error-text" id="error-description">Enter a Valid Description</div>
                        </div>

                        <div class="submit-container">
                            <button name="btnSubmit" value="Submit" class="submitContact-btn" id="btnSubmit-contact">
                                <i class="fa-solid fa-paper-plane"></i>
                                <p>Submit</p>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <?php include("footer.php") ?>
        <script src="../../scripts/validation.js"></script>
    </body>
</html>