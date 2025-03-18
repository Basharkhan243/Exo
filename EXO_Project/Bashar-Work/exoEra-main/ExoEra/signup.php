<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    include 'partials/_db_connect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $sAdress = $_POST["sAdress"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $pcode = $_POST["pcode"];

    $cpassword = $_POST["cpassword"];

    $existSql = "SELECT * FROM `exo` WHERE `name` = '$username'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        // $exist = true;
        $showError = "User Already Exists";
    } else {
        if ($password == $cpassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `exo` (`name`, `email`, `sAdress`, `city`, `state`, `pcode`, `password`, `dt`) VALUES ('$username', '$email', '$sAdress', '$city', '$state', '$pcode', '$hash', current_timestamp());";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $showAlert = true;
            }
        } else {
            $showError = "Passwords do not match";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Professional Portfolio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    if ($showAlert) {
        echo '<div class="alert alert-primary" role="alert">
  Successfully Signed Up
</div>';
    }

    if ($showError) {
        echo '<div class="alert alert-danger" role="alert">
  ' . $showError . '
</div>';
    }
    ?>
    <div class="signup-container">
        <div class="signup-form-container">
            <div class="theme-toggle">
                <i class="fas fa-sun"></i>
                <label class="switch">
                    <input type="checkbox" id="theme-switch">
                    <span class="slider round"></span>
                </label>
                <i class="fas fa-moon"></i>
            </div>
            <div class="form-header">
                <h2>Create Account</h2>
                <p>Please fill in your information to get started</p>
            </div>

            <form method="POST" class="signup-form" id="signupForm">
                <!-- Personal Information -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-user-circle"></i>
                        <h3>Personal Information</h3>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">Name</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" name="username" id="firstName" placeholder="John" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" id="email" placeholder="john@example.com" required>
                            </div>
                        </div>
                        <!-- <divv class="form-group">
                            <label for="phone">Phone Number</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone"></i>
                                <input type="tel" name="phone" id="phone" placeholder="+1 (234) 567-8900" required>
                            </div>
                        </divv> -->
                    </div>

                    <!-- <divv class="form-row">
                        <divv class="form-group">
                            <label for="gender">Gender</label>
                            <div class="input-with-icon">
                                <i class="fas fa-venus-mars"></i>
                                <select name="gender" id="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                    <option value="prefer-not">Prefer not to say</option>
                                </select>
                            </div>
                        </divv>
                    </divv> -->
                </div>

                <!-- Address Details -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Address Details</h3>
                    </div>
                    <div class="form-group">
                        <label for="street">Street Address</label>
                        <div class="input-with-icon">
                            <i class="fas fa-home"></i>
                            <input type="text" name="sAdress" id="street" placeholder="1234 Main St" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <div class="input-with-icon">
                                <i class="fas fa-city"></i>
                                <input type="text" name="city" id="city" placeholder="New York" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state">State/Province</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map"></i>
                                <input type="text" name="state" id="state" placeholder="NY" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="zipcode">Postal Code</label>
                            <div class="input-with-icon">
                                <i class="fas fa-mail-bulk"></i>
                                <input type="text" name="pcode" id="zipcode" placeholder="12345" required>
                            </div>
                        </div>
                        <!-- <divvvv class="form-group">
                            <label for="country">Country</label>
                            <div class="input-with-icon">
                                <i class="fas fa-globe"></i>
                                <select name="country" id="country" required>
                                    <option value="" disabled selected>Select your country</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AU">Australia</option>
                                    <option value="AT">Austria</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BR">Brazil</option>
                                    <option value="CA">Canada</option>
                                    <option value="CN">China</option>
                                    <option value="CO">Colombia</option>
                                    <option value="DK">Denmark</option>
                                    <option value="EG">Egypt</option>
                                    <option value="FI">Finland</option>
                                    <option value="FR">France</option>
                                    <option value="DE">Germany</option>
                                    <option value="GR">Greece</option>
                                    <option value="IN">India</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="JP">Japan</option>
                                    <option value="KR">Korea, Republic of</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MX">Mexico</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NO">Norway</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SG">Singapore</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="ES">Spain</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="TW">Taiwan</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TR">Turkey</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="US">United States</option>
                                    <option value="VN">Vietnam</option>
                                </select>
                            </div>
                        </divvvv> -->
                    </div>
                </div>

                <!-- Account Security -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Account Security</h3>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" required>
                        </div>
                        <div class="password-strength"></div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="cpassword" id="confirmPassword" required>
                        </div>
                    </div>
                </div>


                <div id="createNewAccount" class="submit-btn">
                    <i class="fas fa-user-plus"></i>

                    <button style="border: none; background-color: transparent;" type="submit">Create Account</button>
                </div>
            </form>

            <!-- SOCIAL LOGIN -->
            <div class="social-login">
                <p>Or sign up with</p>
                <div class="social-buttons">
                    <button type="button" class="google-btn" id="googleSignup">
                        <i class="fab fa-google"></i> Sign up with Google
                    </button>
                    <button type="button" class="facebook-btn" id="facebookSignup">
                        <i class="fab fa-facebook"></i> Sign up with Facebook
                    </button>
                </div>
            </div>




            <div class="form-footer">
                <p>Already have an account? <a href="login.html">Sign In</a></p>
            </div>
        </div>

        <div class="signup-image">
            <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                alt="Professional workspace">
            <!-- <div class="image-overlay">
                <div class="welcome-text">
                    <h1>Welcome to Our Community</h1>
                    <p>Join thousands of professionals worldwide</p>
                </div>
            </div> -->
        </div>
    </div>

    <!-- <script src="signup.js"></script> -->


    <!-- Your JavaScript file -->
    <script type="module">
        import {
            loginWithGoogle,
            loginWithFacebook
        } from "./auth.js";

        document.getElementById("googleSignup").addEventListener("click", loginWithGoogle);
        document.getElementById("facebookSignup").addEventListener("click", loginWithFacebook);
    </script>

</body>

</html>