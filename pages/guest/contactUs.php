<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        
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
                            <input type="text" name="txtFullName" id="fullname">
                        </div>

                        <div class="input-box">
                            <label for="email">Email *</label>
                            <input type="text" name="txtEmail" id="email">
                        </div>

                        <div class="input-box">
                            <label for="contactNumber">Contact Number *</label>
                            <input type="text" name="txtContactNumber" id="contactNumber">
                        </div>

                        <div class="input-box">
                            <label for="subject">Subject *</label>
                            <select name="txtSubject" id="subject">
                                <option value="">-- Please Select --</option>
                                <option value="Account Registration Issue">Account Registration Issue</option>
                                <option value="GreenPoints & Rewards Issue">GreenPoints & Rewards Issue</option>
                                <option value="Join the Committee">Join the Committee</option>
                                <option value="Partnership & Collaboration">Partnership & Collaboration</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="Feedback & Suggestions">Feedback & Suggestions</option>
                                <option value="General Inquiry">General Inquiry</option>
                            </select>
                        </div>

                        <div class="input-box">
                            <label for="description">Description *</label>
                            <textarea name="txtDescription" id="description"></textarea>
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
    </body>
</html>