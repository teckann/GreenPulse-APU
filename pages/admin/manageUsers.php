<?php
    include("../../conn.php");
    include("../../backend/sessionData.php");
    include("../../backend/idGenerator.php");

    $sql = "SELECT * FROM users";
    $target = "";

    if (isset($_GET["btnSearch"])) {
        $target = $_GET["target"];

        $sql = "SELECT * FROM users WHERE name LIKE '%{$target}%'";
    }

    if (isset($_GET["btnChangeStatus"])) {
        $targetUserID = $_GET["target_userID"];
        $nextStatus = $_GET["next_status"];

        if ($targetUserID == $userID) {
            echo "<script>
                    alert('You cannot inactive yourself');
                    window.location.href = 'manageUsers.php';
                  </script>";
        }
        else {
            $sql_updateStatus = "UPDATE users SET account_status = '$nextStatus' WHERE user_id = '$targetUserID'";
        
            if(mysqli_query($conn, $sql_updateStatus)) {
                echo "<script>
                        alert('--- Successfully Updated User Status ---\\nUser ID: $targetUserID\\nNew Status: $nextStatus');
                        window.location.href = 'manageUsers.php';
                      </script>";
            }
        }
    }

    if (isset($_GET["btnFilter"])) {
        $role = $_GET["txtRole"];
        $accountStatus = $_GET["txtStatus"];

        if (!empty($role) && !empty($accountStatus)) {
            $sql = "SELECT * FROM users 
                    WHERE role = '$role' AND account_status = '$accountStatus'";
        }
        elseif (!empty($role)) {
            $sql = "SELECT * FROM users 
                    WHERE role = '$role'";
        }
        elseif (!empty($accountStatus)) {
            $sql = "SELECT * FROM users 
                    WHERE account_status = '$accountStatus'";
        }
    }

    $result = mysqli_query($conn, $sql);


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = trim($_POST["name"]);
        $emailID = trim($_POST["emailID"]);
        $contactNumber = trim($_POST["contactNumber"]);
        $dateOfBirth = $_POST["dateOfBirth"];
        $courseName = $_POST["courseName"];
        $gender = $_POST["gender"];
        $nationality = $_POST["nationality"];
        $role = $_POST["role"];

        $email = strtoupper($emailID) . "@mail.apu.edu.my";
        $newUserID = newID($conn, "users", "U");
        $registrationDate =  date("Y-m-d");

        // default password
        $arr = explode("-", $dateOfBirth);
        $dob = $arr[1] .$arr[2];
        $defaultPassword = $newUserID . "@" . $dob;
        $hash = password_hash($defaultPassword, PASSWORD_DEFAULT);

        $avatar = "src/avatars/default.png";

        $sql_addUser = "";

        if ($role == "admin" || $role == "committee") {
            $sql_addUser = "INSERT INTO users (user_id, name, nationality, gender, date_of_birth, contact_number, 
                            education_email, course_name, registration_date, password, avatar, role)
                            VALUES ('$newUserID', '$name', '$nationality', '$gender', '$dateOfBirth', '$contactNumber', 
                            '$email', '$courseName', '$registrationDate', '$hash', '$avatar', '$role')";
        }
        else {
            $greenPoints = 0;
            $totalEarned = 0;

            $sql_addUser = "INSERT INTO users (user_id, name, nationality, gender, date_of_birth, contact_number, 
                            education_email, course_name, registration_date, password, green_points, total_earned, avatar, role)
                            VALUES ('$newUserID', '$name', '$nationality', '$gender', '$dateOfBirth', '$contactNumber', 
                            '$email', '$courseName', '$registrationDate', '$hash', '$greenPoints', '$totalEarned', '$avatar', '$role')";
        }

        if(mysqli_query($conn, $sql_addUser)) {
            echo "<script>
                    alert('--- Successfully Added New User ---\\nAccess Granted!\\nUser ID: $newUserID\\nRole: $role\\nDefault Password Format: UXXX@MMDD');
                    window.location.href = 'manageUsers.php';
                  </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Users</title>
        <link rel="stylesheet" href="../../styles/admin.css">

        <?php include("library.php") ?>
    </head>
    <body>
        <?php include("header.php"); ?>

        <main class="search-area">
            <h1>Manage Users</h1>
            <h2 class="page-subTitle">Overview of all registered accounts</h2>

            <div class="action-bar" style="margin: 1em 0;">
                <form action="" method="GET">
                    <div class="table-search-box">
                        <input type="text" name="target" placeholder="Search user here">
                        <i class="fa-solid fa-magnifying-glass"></i>

                        <button name="btnSearch" type="submit" value="Search" class="table-btnSearch" title="Search"></button>
                    </div>
                </form>

                <form action="" method="GET" class="select-container">
                    <div class="select-boxs">
                        <div>
                            <label for="role">Role: </label>
                            <select name="txtRole" id="role">
                                <option value="">All</option>
                                <option value="admin">Admin</option>
                                <option value="committee">Committee</option>
                                <option value="volunteer">Volunteer</option>
                            </select>
                        </div>

                        <div>
                            <label for="status">Status: </label>
                            <select name="txtStatus" id="status">
                                <option value="">All</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <button class="print" onclick="window.print()">
                            <i class="fa-solid fa-print"></i>
                        </button>
                    </div>

                    <div class="action-btns">
                        <button name="btnFilter" type="submit" value="Filter" class="filter-btn">
                            <i class="fa-solid fa-filter"></i>
                            <p>Filter</p>
                        </button>

                        <button type="button" class="addNewUser-btn">
                            <i class="fa-solid fa-user-plus"></i>
                            <p>Add New User</p>
                        </button>
                    </div>
                </form>
            </div>

            <div class="overlay" id="popupOverlay"></div>

            <div class="popup" id="popup">
                <div class="popup-header">
                    <div class="info-title">
                        <h3>Add New User</h3>
                        <div class="line"></div>
                    </div>
                    <button id="popup-close-menu" class="icon-menu">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="" method="POST" class="popup-form">
                    <div class="popup-scroll-area">
                        <div class="popup-input">
                            <label for="fullname">Full Name *</label>
                            <input type="text" name="name" id="fullname" placeholder="e.g. Marcus">
                            <div class="popup-error-text" id="error-fullname">Enter a Valid Name</div>
                        </div>

                        <div class="popup-input">
                            <label for="email">Education Email *</label>
                            <div style = "display: flex; flex-direction: row; align-items: center; gap:5px;">
                                <input type="text" name="emailID" id="email" placeholder="e.g. TP012345">
                                <label for="email">@mail.apu.edu.my</label>
                            </div>
                            <div class="popup-error-text" id="error-email">Enter a Valid APU Education Email</div>
                        </div>

                        <div class="popup-row">
                            <div class="popup-input popup-contact">
                                <label for="contactNumber">Contact Number *</label>
                                <div class="popup-sub-input">
                                    <label for="contact">+60 </label>
                                    <input type="text" name="contactNumber" id="contact" placeholder="e.g. 0123456789">
                                </div>
                                <div class="popup-error-text" id="error-contactNumber">Enter a Valid Contact Number</div>
                            </div>

                            <div class="popup-input popup-dob">
                                <label for="dob">DOB *</label>
                                <input type="date" name="dateOfBirth" id="dob">
                                <div class="popup-error-text" id="error-dob">Select DOB</div>
                            </div>
                        </div>

                        <div class="popup-input">
                            <label for="course">Course Enrolled *</label>
                            <select name="courseName" id="course">
                                <option value="">-- Please Select --</option>
                                <option value="Diploma in ICT">Diploma in ICT</option>
                                <option value="Diploma in ICT (Software Engineering)">Diploma in ICT (Software Engineering)</option>
                                <option value="Diploma in ICT (Data Informatics)">Diploma in ICT (Data Informatics)</option>
                                <option value="Diploma in ICT (Interactive Technology)">Diploma in ICT (Interactive Technology)</option>
                                <option value="Diploma in Business Information Technology">Diploma in Business Information Technology</option>
                                <option value="Diploma in Business Administration">Diploma in Business Administration</option>
                                <option value="Diploma in Mechatronic Engineering">Diploma in Mechatronic Engineering</option>
                                <option value="Diploma in Accounting">Diploma in Accounting</option>
                                <option value="Diploma in Design & Media">Diploma in Design & Media</option>
                                <option value="Diploma in International Studies">Diploma in International Studies</option>
                                <option value="Diploma in Events Management">Diploma in Events Management</option>
                                <option value="Diploma in Hotel Management">Diploma in Hotel Management</option>
                            </select>
                            <div class="popup-error-text" id="error-course">Select Course</div>
                        </div>

                        <div class="popup-row">
                            <div class="popup-input">
                                <label for="gender">Gender *</label>
                                <div style="display: flex; flex-direction: row; gap:15px; margin-top: 0.5em;">
                                    <label><input type="radio" name="gender" value="M" class="popup-radio"> Male</label>
                                    <label><input type="radio" name="gender" value="F" class="popup-radio"> Female</label>
                                </div>
                                <div class="popup-error-text" id="error-gender">Select Gender</div>
                            </div>

                            <div class="popup-input popup-nationality">
                                <label for="nationality">Nationality *</label>
                                <select name="nationality" id="nationality">
                                    <option value="">-- Please Select --</option>
                                    <option value="Malaysian">Malaysian</option>
                                    <option value="Afghan">Afghan</option>
                                    <option value="Albanian">Albanian</option>
                                    <option value="Algerian">Algerian</option>
                                    <option value="American">American</option>
                                    <option value="Andorran">Andorran</option>
                                    <option value="Angolan">Angolan</option>
                                    <option value="Antiguans">Antiguans</option>
                                    <option value="Argentinean">Argentinean</option>
                                    <option value="Armenian">Armenian</option>
                                    <option value="Australian">Australian</option>
                                    <option value="Austrian">Austrian</option>
                                    <option value="Azerbaijani">Azerbaijani</option>
                                    <option value="Bahamian">Bahamian</option>
                                    <option value="Bahraini">Bahraini</option>
                                    <option value="Bangladeshi">Bangladeshi</option>
                                    <option value="Barbadian">Barbadian</option>
                                    <option value="Barbudans">Barbudans</option>
                                    <option value="Batswana">Batswana</option>
                                    <option value="Belarusian">Belarusian</option>
                                    <option value="Belgian">Belgian</option>
                                    <option value="Belizean">Belizean</option>
                                    <option value="Beninese">Beninese</option>
                                    <option value="Bhutanese">Bhutanese</option>
                                    <option value="Bolivian">Bolivian</option>
                                    <option value="Bosnian">Bosnian</option>
                                    <option value="Brazilian">Brazilian</option>
                                    <option value="British">British</option>
                                    <option value="Bruneian">Bruneian</option>
                                    <option value="Bulgarian">Bulgarian</option>
                                    <option value="Burkinabe">Burkinabe</option>
                                    <option value="Burmese">Burmese</option>
                                    <option value="Burundian">Burundian</option>
                                    <option value="Cambodian">Cambodian</option>
                                    <option value="Cameroonian">Cameroonian</option>
                                    <option value="Canadian">Canadian</option>
                                    <option value="Cape Verdean">Cape Verdean</option>
                                    <option value="Central African">Central African</option>
                                    <option value="Chadian">Chadian</option>
                                    <option value="Chilean">Chilean</option>
                                    <option value="Chinese">Chinese</option>
                                    <option value="Colombian">Colombian</option>
                                    <option value="Comoran">Comoran</option>
                                    <option value="Congolese">Congolese</option>
                                    <option value="Costa Rican">Costa Rican</option>
                                    <option value="Croatian">Croatian</option>
                                    <option value="Cuban">Cuban</option>
                                    <option value="Cypriot">Cypriot</option>
                                    <option value="Czech">Czech</option>
                                    <option value="Danish">Danish</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominican">Dominican</option>
                                    <option value="Dutch">Dutch</option>
                                    <option value="East Timorese">East Timorese</option>
                                    <option value="Ecuadorean">Ecuadorean</option>
                                    <option value="Egyptian">Egyptian</option>
                                    <option value="Emirian">Emirian</option>
                                    <option value="Equatorial Guinean">Equatorial Guinean</option>
                                    <option value="Eritrean">Eritrean</option>
                                    <option value="Estonian">Estonian</option>
                                    <option value="Ethiopian">Ethiopian</option>
                                    <option value="Fijian">Fijian</option>
                                    <option value="Filipino">Filipino</option>
                                    <option value="Finnish">Finnish</option>
                                    <option value="French">French</option>
                                    <option value="Gabonese">Gabonese</option>
                                    <option value="Gambian">Gambian</option>
                                    <option value="Georgian">Georgian</option>
                                    <option value="German">German</option>
                                    <option value="Ghanaian">Ghanaian</option>
                                    <option value="Greek">Greek</option>
                                    <option value="Grenadian">Grenadian</option>
                                    <option value="Guatemalan">Guatemalan</option>
                                    <option value="Guinea-Bissauan">Guinea-Bissauan</option>
                                    <option value="Guinean">Guinean</option>
                                    <option value="Guyanese">Guyanese</option>
                                    <option value="Haitian">Haitian</option>
                                    <option value="Herzegovinian">Herzegovinian</option>
                                    <option value="Honduran">Honduran</option>
                                    <option value="Hungarian">Hungarian</option>
                                    <option value="Icelander">Icelander</option>
                                    <option value="Indian">Indian</option>
                                    <option value="Indonesian">Indonesian</option>
                                    <option value="Iranian">Iranian</option>
                                    <option value="Iraqi">Iraqi</option>
                                    <option value="Irish">Irish</option>
                                    <option value="Israeli">Israeli</option>
                                    <option value="Italian">Italian</option>
                                    <option value="Ivorian">Ivorian</option>
                                    <option value="Jamaican">Jamaican</option>
                                    <option value="Japanese">Japanese</option>
                                    <option value="Jordanian">Jordanian</option>
                                    <option value="Kazakhstani">Kazakhstani</option>
                                    <option value="Kenyan">Kenyan</option>
                                    <option value="Kittian And Nevisian">Kittian and Nevisian</option>
                                    <option value="Kuwaiti">Kuwaiti</option>
                                    <option value="Kyrgyz">Kyrgyz</option>
                                    <option value="Laotian">Laotian</option>
                                    <option value="Latvian">Latvian</option>
                                    <option value="Lebanese">Lebanese</option>
                                    <option value="Liberian">Liberian</option>
                                    <option value="Libyan">Libyan</option>
                                    <option value="Liechtensteiner">Liechtensteiner</option>
                                    <option value="Lithuanian">Lithuanian</option>
                                    <option value="Luxembourger">Luxembourger</option>
                                    <option value="Macedonian">Macedonian</option>
                                    <option value="Malagasy">Malagasy</option>
                                    <option value="Malawian">Malawian</option>
                                    <option value="Maldivan">Maldivan</option>
                                    <option value="Malian">Malian</option>
                                    <option value="Maltese">Maltese</option>
                                    <option value="Marshallese">Marshallese</option>
                                    <option value="Mauritanian">Mauritanian</option>
                                    <option value="Mauritian">Mauritian</option>
                                    <option value="Mexican">Mexican</option>
                                    <option value="Micronesian">Micronesian</option>
                                    <option value="Moldovan">Moldovan</option>
                                    <option value="Monacan">Monacan</option>
                                    <option value="Mongolian">Mongolian</option>
                                    <option value="Moroccan">Moroccan</option>
                                    <option value="Mosotho">Mosotho</option>
                                    <option value="Motswana">Motswana</option>
                                    <option value="Mozambican">Mozambican</option>
                                    <option value="Namibian">Namibian</option>
                                    <option value="Nauruan">Nauruan</option>
                                    <option value="Nepalese">Nepalese</option>
                                    <option value="New Zealander">New Zealander</option>
                                    <option value="Ni-Vanuatu">Ni-Vanuatu</option>
                                    <option value="Nicaraguan">Nicaraguan</option>
                                    <option value="Nigerien">Nigerien</option>
                                    <option value="North Korean">North Korean</option>
                                    <option value="Northern Irish">Northern Irish</option>
                                    <option value="Norwegian">Norwegian</option>
                                    <option value="Omani">Omani</option>
                                    <option value="Pakistani">Pakistani</option>
                                    <option value="Palauan">Palauan</option>
                                    <option value="Panamanian">Panamanian</option>
                                    <option value="Papua New Guinean">Papua New Guinean</option>
                                    <option value="Paraguayan">Paraguayan</option>
                                    <option value="Peruvian">Peruvian</option>
                                    <option value="Polish">Polish</option>
                                    <option value="Portuguese">Portuguese</option>
                                    <option value="Qatari">Qatari</option>
                                    <option value="Romanian">Romanian</option>
                                    <option value="Russian">Russian</option>
                                    <option value="Rwandan">Rwandan</option>
                                    <option value="Saint Lucian">Saint Lucian</option>
                                    <option value="Salvadoran">Salvadoran</option>
                                    <option value="Samoan">Samoan</option>
                                    <option value="San Marinese">San Marinese</option>
                                    <option value="Sao Tomean">Sao Tomean</option>
                                    <option value="Saudi">Saudi</option>
                                    <option value="Scottish">Scottish</option>
                                    <option value="Senegalese">Senegalese</option>
                                    <option value="Serbian">Serbian</option>
                                    <option value="Seychellois">Seychellois</option>
                                    <option value="Sierra Leonean">Sierra Leonean</option>
                                    <option value="Singaporean">Singaporean</option>
                                    <option value="Slovakian">Slovakian</option>
                                    <option value="Slovenian">Slovenian</option>
                                    <option value="Solomon Islander">Solomon Islander</option>
                                    <option value="Somali">Somali</option>
                                    <option value="South African">South African</option>
                                    <option value="South Korean">South Korean</option>
                                    <option value="Spanish">Spanish</option>
                                    <option value="Sri Lankan">Sri Lankan</option>
                                    <option value="Sudanese">Sudanese</option>
                                    <option value="Surinamer">Surinamer</option>
                                    <option value="Swazi">Swazi</option>
                                    <option value="Swedish">Swedish</option>
                                    <option value="Swiss">Swiss</option>
                                    <option value="Syrian">Syrian</option>
                                    <option value="Taiwanese">Taiwanese</option>
                                    <option value="Tajik">Tajik</option>
                                    <option value="Tanzanian">Tanzanian</option>
                                    <option value="Thai">Thai</option>
                                    <option value="Togolese">Togolese</option>
                                    <option value="Tongan">Tongan</option>
                                    <option value="Trinidadian Or Tobagonian">Trinidadian or Tobagonian</option>
                                    <option value="Tunisian">Tunisian</option>
                                    <option value="Turkish">Turkish</option>
                                    <option value="Tuvaluan">Tuvaluan</option>
                                    <option value="Ugandan">Ugandan</option>
                                    <option value="Ukrainian">Ukrainian</option>
                                    <option value="Uruguayan">Uruguayan</option>
                                    <option value="Uzbekistani">Uzbekistani</option>
                                    <option value="Venezuelan">Venezuelan</option>
                                    <option value="Vietnamese">Vietnamese</option>
                                    <option value="Welsh">Welsh</option>
                                    <option value="Yemenite">Yemenite</option>
                                    <option value="Zambian">Zambian</option>
                                    <option value="Zimbabwean">Zimbabwean</option>
                                </select>
                                <div class="popup-error-text" id="error-nationality">Select Nationality</div>
                            </div>
                        </div>

                        <div class="popup-input">
                            <label for="permission">Access Permission *</label>
                            <select name="role" id="permission">
                                <option value="">-- Please Select --</option>
                                <option value="admin">Admin</option>
                                <option value="committee">Committee</option>
                                <option value="volunteer">Volunteer</option>
                            </select>
                            <div class="popup-error-text" id="error-permission">Select Access Permission</div>
                        </div>
                    </div>

                    <div class="submit-container">
                        <button name="btnSubmit" value="Submit" class="submit-btn" id="btnSubmit-addNewUser">
                            <i class="fa-solid fa-paper-plane"></i>
                            <p>Submit</p>
                        </button>
                    </div>
                </form>
            </div>

            <?php
                $users = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $users[] = $row;
                }
            ?>

            <div class="flex-container desktop-table" style="margin: 1em 0;">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Education Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach ($users as $row):
                                $textColor = "";
                                $icon = "";
                                $title = "";
                                $nextStatus = "";

                                if ($row["account_status"] === "Active") {
                                    $icon = "<i class='fa-solid fa-ban'></i>";
                                    $textColor = "#28a745";
                                    $nextStatus = "Inactive";
                                }
                                elseif ($row["account_status"] === "Inactive") {
                                    $icon = "<i class='fa-solid fa-undo'></i>";
                                    $textColor = "#dc3545";
                                    $nextStatus = "Active";
                                }
                                $title = $nextStatus;

                                $eventDateTime = $row["event_datetime"];
                                $formatted_dateTime = date("d M Y (g:i A)", strtotime($eventDateTime));

                                echo '<tr>
                                        <td>' . $row['user_id'] . '</td>
                                        <td>' . $row['name'] . '</td>
                                        <td>' . $row['education_email'] . '</td>
                                        <td>' . ucwords($row['role']) . '</td>
                                        <td style="color:' . $textColor . '">' . $row['account_status'] . '</td>
                                        
                                        <td>
                                            <div class="action-container">
                                                <form action="" method="GET">
                                                    <input type="hidden" name="target_userID" value="' . $row['user_id'] . '">
                                                    <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                                    <button name="btnChangeStatus" type="submit" class="action-btn" title="'. $title .'">
                                                        ' . $icon . '
                                                    </button>
                                                </form>

                                                <a href="viewUserProfile.php?id=' . $row['user_id'] . '" class="action-btn" title="View">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>';
                            endforeach;
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="flex-container mobile-card" style="margin: 1em 0;">
                <?php
                    foreach ($users as $row):
                        $bgColor = "";
                        $icon = "";
                        $title = "";
                        $text = "";
                        $nextStatus = "";

                        if ($row["account_status"] === "Active") {
                            $icon = "<i class='fa-solid fa-ban'></i>";
                            $bgColor = "#28a745";
                            $nextStatus = "Inactive";
                        }
                        elseif ($row["account_status"] === "Inactive") {
                            $icon = "<i class='fa-solid fa-undo'></i>";
                            $bgColor = "#dc3545";
                            $nextStatus = "Active";
                        }
                        $title = $nextStatus;
                        $text = $nextStatus;

                        echo '<div class="cards">
                                <div class="card-header">
                                    <div class="card-id">
                                        <p>User ID</p>
                                        <h3>' . $row['user_id'] . '</h3>
                                    </div>

                                    <div class="card-status" style="background-color:' . $bgColor . '">
                                        <p>' . $row['account_status'] . '</p>
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="card-data">
                                        <p>Name</p>
                                        <p>' . $row['name'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Education Email</p>
                                        <p>' . $row['education_email'] . '</p>
                                    </div>

                                    <div class="card-data">
                                        <p>Role</p>
                                        <p>' . ucwords($row['role']) . '</p>
                                    </div>
                                </div>

                                <div class="card-btns">
                                    <form action="" method="GET">
                                        <input type="hidden" name="target_userID" value="' . $row['user_id'] . '">
                                        <input type="hidden" name="next_status" value="' . $nextStatus . '">

                                        <button name="btnChangeStatus" type="submit" class="card-action-btn card-status-btn" title="'. $title .'">
                                            ' . $icon . '
                                            <p>' . $text . '</p>
                                        </button>
                                    </form>

                                    <a href="viewUserProfile.php?id=' . $row['user_id'] . '" title="View">
                                        <button class="card-action-btn card-view-btn">
                                            View User Details
                                        </button>
                                    </a>
                                </div>
                              </div>';
                    endforeach;
                ?>
            </div>
        </main>

        <?php include("footer.php"); ?>
        
        <script src="../../scripts/admin.js"></script>
        <script src="../../scripts/validation.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>