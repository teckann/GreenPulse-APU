<?php


    include("../../conn.php");

    include("../../backend/sessionData.php");

    $userID = $_SESSION["userID"];

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lim Jin Ming's Portfolio</title>

                
        <link rel="stylesheet" href="../../styles/volunteer.css">
        <script src="../../scripts/volunteer.js"></script>

        <link rel="stylesheet" href="../../styles/portfolio.css">
        <!-- style & ico -->
        <link rel="icon" href="../../src/elements/member4.png" type="image/x-icon">

        <!-- icon  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    </head>

    
    
    <body class="flex-container" style="padding: 0;">


            <?php include("header.php") ?>

        <div class="profileHead">
        <div>
            <div><a href="aboutUs.php" class="backEvent"><i class="fa-solid fa-arrow-left"></i></a> Lim Jin Ming</div>
        </div>

        </div>
    
        <main>
            <div class="portfolio-header">
                <div class="header-1">
                    <img src="../../src/elements/member4.png" alt="" class="avatar">

                    <div class="social-media-big-container">
                        <div class="social-media-container">
                            <a href="https://www.linkedin.com/in/lim-jin-ming-a64710345/" target="_blank" class="social-media-icon">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>

                            <a href="https://github.com/Jimmylim69" target="_blank" class="social-media-icon">
                                <i class="fa-brands fa-github"></i>
                            </a>

                            <a href="https://www.instagram.com/a_xian_xiao?igsh=MWJza3o5eW1kcGIzNA==" target="_blank" class="social-media-icon">
                                <i class="fa-brands fa-instagram"></i>
                            </a>

                            <a href="mailto: limjinming0609@gmail.com" target="_blank" class="social-media-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="header-2">
                    <h1>Lim Jin Ming</h1>
                    <p>Software Engineering Student</p>
                </div>
            </div>

            <div class="portfolio-details">
                <div class="section-container">
                    <p class="section-title">About Me</p>
                    <p class="section-details">
                        I am Lim Jin Ming, a second-year Diploma student majoring in Information  and 
                        Technology specialism in Software Engineering at <strong>Asia Pacific University 
                        (APU)</strong>. I have completed projects involving <strong>python</strong>, <strong>Java</strong> 
                        and <strong>object-oriented programming</strong>, strengthening my practical development and 
                        problem-solving skills.

                        Currently in my fourth semester, I am working towards web developing by building dynamic web applications using HTML, 
                        CSS, and JAVASCRIPT, also PHP and MySQL as my backend foundation. In the future, I hope to further develop my 
                        skills and be involved in more field on software.
                    </p>
                </div>

                <div class="section-container">
                    <p class="section-title">Skills</p>
                    
                    <div class="tech-details">
                        <p>Technical</p>

                        <div class="tech-container">
                            <div class="tech">
                                <img src="../../src/icons/java.svg" class="svg-icon" alt="Java">
                                <p>Java</p>
                            </div>

                            <div class="tech">
                                <img src="../../src/icons/python.svg" class="svg-icon" alt="Python">
                                <p>Python</p>
                            </div>

                            <div class="tech">
                                <img src="../../src/icons/html.svg" class="svg-icon" alt="HTML5">
                                <p>HTML5</p>
                            </div>

                            <div class="tech">
                                <img src="../../src/icons/css.svg" class="svg-icon" alt="CSS3">
                                <p>CSS3</p>
                            </div>

                            <div class="tech">
                                <img src="../../src/icons/javascript.svg" class="svg-icon" alt="JavaScript">
                                <p>JavaScript</p>
                            </div>

                            <div class="tech">
                                <img src="../../src/icons/php.svg" class="svg-icon" alt="PHP">
                                <p>PHP</p>
                            </div>

                            <div class="tech">
                                <img src="../../src/icons/database.svg" class="svg-icon" alt="MySQL">
                                <p>MySQL</p>
                            </div>
                        </div>
                    </div>

                    <div class="tech-details" style="margin-top: 1em;">
                        <p>Development Tools</p>

                        <div class="tech-container">
                            <div class="tech">
                                <img src="../../src/icons/vscode.svg" class="svg-icon" alt="VS Code">
                                <p>VS Code</p>
                            </div>

                            <div class="tech">
                                <img src="../../src/icons/figma.svg" class="svg-icon" alt="Figma">
                                <p>Figma</p>
                            </div>

                            <div class="tech">
                                <img src="../../src/icons/git.svg" class="svg-icon" alt="Git">
                                <p>Git</p>
                            </div>

                            <div class="tech">
                                <img src="../../src/icons/intellij.svg" class="svg-icon" alt="IntelliJ">
                                <p>IntelliJ IDEA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>