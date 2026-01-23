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
            #home {
                color: #707c68;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <?php include("header.php") ?>

        <main class="home-container">
            <div class="home-header">
                <div class="home-header-title">
                    <h1>Building a Sustainable</h1>
                    <h1>Future Together</h1>
                </div>
                <p>Join us in our mission to create a greener, cleaner planet for generations to come. Every action counts, every voice matters.</p>

                <div class="journey-btn-deco">
                    <a href="signUp.php" style="text-decoration: none">
                        <button class="journey-btn">
                            <p>Start Your Journey Now</p>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </a>
                </div>
            </div>

            <div class="flex-container">
                <div class="key-initiative">
                    <div class="key-initiative-header">
                        <h1>Our Key Initiatives</h1>

                        <div>
                            <p>We focus on core areas to </p>
                            <p>create meaningful environmental change</p>
                        </div>
                    </div>

                    <div class="key-initiative-card-container">
                        <div class="key-initiative-card">
                            <i class="fa-solid fa-users-line"></i>
                            
                            <div class="key-initiative-card-details">
                                <h1>Green Campus Initiatives</h1>
                                <p>
                                    Mobilizing the student community through workshops, clean-ups, and sustainability drives. 
                                    We provide a platform for education and active participation to foster a culture of environmental 
                                    stewardship.
                                </p>
                            </div>
                        </div>

                        <div class="key-initiative-card">
                            <i class="fa-solid fa-seedling"></i>

                            <div class="key-initiative-card-details">
                                <h1>Tree Redemption Program</h1>
                                <p>
                                    Our signature reward system where your sustainable habits translate into real impact. Earn points 
                                    for green actions and redeem them to plant trees, turning individual efforts into a greener collective 
                                    legacy.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="function-service">
                    <div class="function-service-header">
                        <h1>Functions and Services</h1>

                        <div>
                            <p>GreenPulse makes going green easy </p>
                            <p>with tree adoption and impactful eco initiatives.</p>
                        </div>
                    </div>

                    <div class="funtion-service-container">
                        <div class="function-service-space1">
                            <h1>Interactive Event Hub</h1>
                            <p>A centralized platform to discover and register for the latest sustainability workshops and clean-ups at APU. Seamlessly track your participation and never miss an opportunity to make an impact.</p>
                        </div>
                        
                        <img src="../../src/elements/environment-bro.png" alt="broken" class="home-image2">

                        <div class="function-service-space2">
                            <h1>Tree Adoption System</h1>
                            <p>Gamify your green journey! Earn eco-points for every event you attend and use them to adopt real trees. Monitor your contribution and watch your digital forest grow along with the campus.</p>
                        </div>
                    </div>
                </div>

                <div class="frequently-asked-question">
                    <div class="faq-header">
                        <h1>Frequently Asked Question</h1>

                        <div>
                            <p>Have a question? </p>
                            <p>Here are some of our most frequently asked!</p>
                        </div>
                    </div>

                    <div class="faq-container">
                        <div class="faq">
                            <button class="question" id="q1" data-value="a1" value="close">
                                <p>What is GreenPulse APU all about?</p>
                                <i class="fa-solid fa-angle-down"></i>
                            </button>

                            <div class="answer" id="a1">
                                <p>
                                    GreenPulse is a student-led initiative at Asia Pacific University designed to 
                                    promote sustainability. We organize eco-friendly events and provide a platform 
                                    where your green actions are rewarded with real environmental impact, specifically 
                                    through our Tree Redemption program.
                                </p>
                            </div>
                        </div>

                        <div class="faq">
                            <button class="question" id="q2" data-value="a2" value="close">
                                <p>Who can participate in GreenPulse events?</p>
                                <i class="fa-solid fa-angle-down"></i>
                                <!-- <div class="faq-icon"><i class="fa-solid fa-angle-down"></i></div> -->
                            </button>

                            <div class="answer" id="a2">
                                <p>
                                    Our events are open to all APU students and staff. whether you are a Foundation, 
                                    Diploma, or Degree student, everyone is welcome to join our movement towards a 
                                    greener campus!
                                </p>
                            </div>
                        </div>

                        <div class="faq">
                            <button class="question" id="q3" data-value="a3" value="close">
                                <p>Do I need to pay to join the events?</p>
                                <i class="fa-solid fa-angle-down"></i>
                            </button>

                            <div class="answer" id="a3">
                                <p>
                                    No, absolutely not! GreenPulse is a 100% free student initiative. Our platform, 
                                    all eco-events, and the Tree Redemption program are completely free of charge for 
                                    the entire APU community.
                                </p>
                            </div>
                        </div>

                        <div class="faq">
                            <button class="question" id="q4" data-value="a4" value="close">
                                <p>Can I redeem other rewards?</p>
                                <i class="fa-solid fa-angle-down"></i>
                            </button>

                            <div class="answer" id="a4">
                                <p>
                                    Absolutely! Your hard work deserves to be rewarded. You can use your GreenPoints to 
                                    redeem exclusive merchandise (like tote bags, tumblers) and other student perks. The 
                                    more events you join, the more rewards you unlock!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("footer.php") ?>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // const questionBtn1 = document.querySelector("#q1");
                // const questionBtn2 = document.querySelector("#q2");
                // const questionBtn3 = document.querySelector("#q3");
                // const questionBtn4 = document.querySelector("#q4");

                // const answer1 = document.querySelector("#a1");
                // const answer2 = document.querySelector("#a2");
                // const answer3 = document.querySelector("#a3");
                // const answer4 = document.querySelector("#a4");

                // questionBtn1.addEventListener("click", (e) => {
                //     e.preventDefault();
                    
                //     if (questionBtn1.value === "close") {
                //         answer1.style.display = "block";
                //         questionBtn1.value = "open";
                //     }
                //     else {
                //         answer1.style.display = "none";
                //         questionBtn1.value = "close";
                //     }
                // });

                const questionsBtn = document.querySelectorAll(".question");

                questionsBtn.forEach((btn) => {
                    btn.addEventListener("click", (e) => {
                        const answer = btn.dataset.value;

                        e.preventDefault();

                        if (btn.value === "close") {
                            document.querySelector(`#${answer}`).style.display = "block";
                            btn.value = "open";
                            
                        }
                        else {
                            document.querySelector(`#${answer}`).style.display = "none";
                            btn.value = "close";
                        }
                    })
                });

            });
        </script>
    </body>
</html>