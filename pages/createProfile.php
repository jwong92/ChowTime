<?php
$pageTitle = "Edit Profile";
require_once 'partial/_header.php';

require_once '../models/db.php'; //Database Class file
require_once '../models/profile.php'; //Profile Logic file
require_once '../models/validation.php'; //Validation Library File
$v = new Validation();
if(isset($_POST['createProfile']))
{
	$textRegex = '/^[a-z]+$/i';
	$passRegex = '/^\w+$/i';
	$addRegex = '/\w+(\s\w+){2,}/';
    $cityRegex = '/(\w+\s?){1,}/';
    // FNAME
    $fname = $_POST['fname'];
    $fnameTest = $v->validateAlphaOnly($textRegex, $fname);
    // LNAME
    $lname = $_POST['lname'];
    $lnameTest = $v->validateAlphaOnly($textRegex, $lname);
    // USERNAME
    $username = $_POST['userName'];
    $usernameTest = $v->validateAlphaOnly($textRegex, $username);
    // EMAIL
    $email = $_POST['email'];
    $emailTest = $v->email($email);
    // PASSWORD 1
    $pass = $_POST['pass'];
    $opassTTest = $v->checkAssignProperty('pass');
    // PASSWORD CONFIRM
    $cpass = $_POST['cPass'];
    $cpassTTest = $v->checkAssignProperty('cPass');
    // CONFIRM PASSWORD
    $passTest = $v->confirmPass($pass,$cpass);
    // ADDRESS
    $addr1 = $_POST['add1'];
    $addr1Test = $v->validateAlphaOnly($addRegex, $addr1);
    // CITY
    $city = $_POST['city'];
    $cityTest = $v->validateAlphaOnly($cityRegex, $city);
    // COUNTRY
    $country = $_POST['country'];
    $countryTest = $v->validateDD($country);
    // PROVINCE
    $prov = $_POST['state'];
    $provTest = $v->validateDD($prov);
    // POSTAL CODE
    $postalc = $_POST['pcode'];
	$postalcTest = $v->postalCode($postalc);
    $admin = 0;
    
    $db = Database::getDb();
    $p = new Profile();

    echo "<pre>";
    var_dump($opassTTest);
    var_dump($cpassTTest);
    var_dump($passTest);
    var_dump($fnameTest);
    var_dump($lnameTest);
    var_dump($usernameTest);
    var_dump($postalcTest);
    var_dump($emailTest);
    var_dump($cityTest);
    var_dump($countryTest);
    var_dump($provTest);
    var_dump($addr1Test);
    var_dump($passTest);
    echo "</pre>";

	if($fnameTest != 0  && $lnameTest != 0 && $usernameTest != 0 && $postalcTest != 0 && $emailTest != 0 && $cpassTTest != null && $cityTest != 0 && $countryTest != 0 && $provTest != 0 && $addr1Test != 0 && $passTest != 0) {
            $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
            $count = $p->createProfile($db, $fname, $lname, $username, $email, $hashedPass, $addr1, $city, $country, $prov, $postalc, $admin);
            if($count)
            {
                header('Location: login.php');
            }
            else
            {
                echo "Account was not created";
            }
        }
	else {
		echo "Error";
	}
}
?>
<link rel="stylesheet" type="text/css" href="../assets/css/whatsCooking.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
</head>

<?php
require_once 'partial/_mainnav.php';
?>
	<main class="container ddwrapper  mb-5">
<form action="createProfile.php" method="post" name="createP">
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="fname" for="fname">First Name</label>
            <input type="text" name="fname" id="fname" class="form-control"/>
            <label name="err_fname" for="fname" id="err_fname" ></label>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="lname" for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" class="form-control"/>
            <label name="err_lname" for="lname" id="err_lname" ></label>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="userName" for="userName">Username</label>
            <input type="text" name="userName" id="userName" class="form-control"/>
            <label name="err_userName" for="userName" id="err_userName" ></label>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="email" for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control"/>
            <label name="err_email" for="email" id="err_email" ></label>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="pass" for="pass">Password</label>
            <input type="password" name="pass" id="pass" class="form-control"/>
            <label name="err_pass" for="pass" id="err_pass" ></label>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="cPass" for="cPass">Confirm Password</label>
            <input type="password" name="cPass" id="cPass" class="form-control"/>
            <label name="err_cPass" for="cPass" id="err_cPass" ></label>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="country" for="country">Country</label>
            <label name="err_country" for="country" id="err_country" ></label>
			<select name="country" id="country" class="form-control">
                <option value="">--Select your Country--</option>
                <option value="Canada">Canada</option>
            </select>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="state" for="state">Province/State</label>
            <label name="err_state" for="state" id="state" ></label>
			<select name="state" id="state" class="form-control">
                <option value="">--Select your Province--</option>
                <option value="ON">Ontario</option>
                <option value="QC">Quebec</option>
                <option value="BC">British Columbia</option>
                <option value="AB">Alberta</option>
                <option value="MB">Manitoba</option>
                <option value="SK">Saskatchewan</option>
                <option value="NS">Nova Scotia</option>
                <option value="NB">New Brunswick</option>
                <option value="NL">Newfoundland and Labrador</option>
                <option value="PE">Prince Edward Island</option>
                <option value="NT">Northwest Territories</option>
                <option value="NU">Nunavut</option>
                <option value="YT">Yukon</option>
            </select>
        </div>
	</div>
	<div class="row">
        <div class="form-group col-lg-6">
            <label name="add1" for="add1">Address #1</label>
            <input type="text" name="add1" id="add1" class="form-control"/>
            <label name="err_add1" for="add1" id="err_add1" ></label>
        </div>
    </div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="city" for="city">City</label>
            <input type="text" name="city" id="city" class="form-control"/>
            <label name="err_city" for="city" id="err_city"></label>
        </div>
	</div>
    <div class="row">
		<div class="form-group col-lg-6">
            <label name="pcode" for="pcode">Postal Code</label>
            <input type="text" name="pcode" id="pcode" class="form-control"/>
            <label name="err_pcode" for="pcode" id="err_pcode"></label>
        </div>
	</div>
    <div class="row">
        <div class="form-group">
            <button type="submit" name="createProfile" for="createP" class="form-control">Create Profile</button>
        </div>
    </div>
	</main>

<?php
    require_once 'partial/_footer.php';
?>
</body>
</html>