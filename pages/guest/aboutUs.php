<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us</title>
        
        <link rel="stylesheet" href="../../styles/guest.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            #aboutUs {
                color: #707c68;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <?php include("header.php") ?>

        <main class="about-us-container">
            <div class="about-us-header">
                <div class="model">
                    <h1>ABOUT US</h1>
                </div>
            </div>

            <div class="flex-container">
                <div class="container-1">
                    <div class="vision-mission-container">
                        <h2 class="vision-mission-title">Vision & Mission</h2>

                        <div class="mission-vision-content">
                            <div class="mission-vision-details">
                                <h1>Our Vision</h1>
                                <p>A sustainable APU campus driven by a community of changemakers, where green actions lead to a greener tomorrow.</p>
                            </div>
                            
                            <div class="mission-vision-details">
                                <h1>Our Mission</h1>
                                <p>To mobilize the APU community through accessible eco-events and rewarding experiences. By integrating education with action—specifically through our signature Tree Redemption initiative—we turn individual contributions into collective environmental impact.</p>
                            </div>
                        </div>
                    </div>
                    <img src="../../src/elements/deco.jpg" alt="" class="vision-mission-image">
                </div>

                <div class="container-2">
                    <h2 class="meet-our-team-title">Meet Our Team</h2>
                    <h1>Our Project Contributors</h1>

                    <div class="member-card-container">
                        <div class="member-card">
                            <img src="../../src/elements/member1.png" alt="Member 1 Picture">
                            <div class="member-details">
                                <h3>Gan Teck Ann</h3>
                                <p>Project Leader</p>
                            </div>
                        </div>

                        <div class="member-card">
                            <img src="../../src/elements/member2.png" alt="Member 2 Picture">
                            <div class="member-details">
                                <h3>Goh Yang Ee</h3>
                                <p>Project Contributor</p>
                            </div>
                        </div>

                        <div class="member-card">
                            <img src="../../src/elements/member3.png" alt="Member 3 Picture">
                            <div class="member-details">
                                <h3>Cynthia Tan Xin Ru</h3>
                                <p>Project Contributor</p>
                            </div>
                        </div>

                        <div class="member-card">
                            <img src="../../src/elements/member4.png" alt="Member 4 Picture">
                            <div class="member-details">
                                <h3>Lim Jin Ming</h3>
                                <p>Project Contributor</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-2">
                    <h2 class="meet-our-team-title">Visit Us</h2>
                    <h1>Our Location</h1>

                    <div class="visit-us-container">
                        <div class="map-container">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.146627457591!2d101.70016431475706!3d3.055405697775535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4abb795025d9%3A0x1c37182a714ba968!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1679999999999!5m2!1sen!2smy" 
                                class="visitUs-map"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- <?php include("footer.php") ?> -->
    </body>
</html>