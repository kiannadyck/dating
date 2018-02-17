<?php
/*
 * Kianna Dyck
 * 01/19/2018
 * This is the controller for my dating website.
 */

// Require the autoload file
require_once('vendor/autoload.php');

// Start a session
session_start();

// Create an instance of the Base class
$f3 = Base::instance();

// Set debug level 0 = off, 3 = max level
//$f3->set('DEBUG', 3);

// Define a default route
$f3->route('GET /', function() {

    $view = new View();
    echo $view->render
    ('pages/home.html');

});

// Define route for Personal Information Page
$f3->route('GET|POST /personal-info', function($f3) {

    if(isset($_POST['submit'])) {
        // store values from POST in variables
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];

        $premium = $_POST['premium'];

        // include validation file
        include('models/data_validation.php');

        // define an empty array called $errors
        $errors = array();

        if (!validName($firstName))
        {
            $errors['first'] = "Please enter a valid first name.";
        }

        if (!validName($lastName))
        {
            $errors['last'] = "Please enter a valid last name.";
        }

        if (!validAge($age))
        {
            $errors['age'] = "Age must be 18 or older to be considered eligible for K's Dating Website services.";
        }

        if (!validPhone($phone))
        {
            $errors['phone'] = "Please enter a valid 10 digit phone number, 
            no parentheses or spaces, hyphens optional.";
        }

        // Initialize a $success variable, true if $errors array is true, false otherwise
        $success = sizeof($errors) == 0;

        if (strlen($phone) == 10) {
            // insert hyphens
            $areaCode = substr($phone, 0, 3);
            $secondPart = substr($phone, 3,3);
            $thirdPart = substr($phone,6,4);
            $phoneNum = "$areaCode-$secondPart-$thirdPart";
            $f3->set('phone', $phoneNum);
        } else {
            $f3->set('phone', $phone);
        }

        // set hive variables (used for sticky forms and displaying error messages)
        $f3->set('fName', $firstName);
        $f3->set('lName', $lastName);
        $f3->set('age', $age);
        $f3->set('gender', $gender);
        $f3->set('errors', $errors);

        $f3->set('premium', $premium);

        // if no errors in forms
        if($success) {
            // check if premium is selected
            if(isset($premium)) {
                // create a new premium member object
                $user = new PremiumMember($f3->get(fName),
                    $f3->get('lName'), $f3->get('age'), $f3->get('gender'), $f3->get('phone'));
            } else {
                // create a new member object
                $user = new Member($f3->get(fName),
                    $f3->get('lName'), $f3->get('age'), $f3->get('gender'), $f3->get('phone'));
            }

            $_SESSION['user'] = $user;

            // reroute to next page
            $f3->reroute('./profile');
        }
    }

    $template = new Template();
    echo $template->render('pages/personal_info.html');
});

// Define route for profile Page
$f3->route('GET|POST /profile', function($f3) {

    $user = $_SESSION['user'];

    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $bio = $_POST['bio'];

        // set hive variables (used for sticky forms and displaying error messages)
        $f3->set('email', $email);
        $f3->set('state', $state);
        $f3->set('seeking', $seeking);
        $f3->set('bio', $bio);

        // set email, state, seeking, and bio in member/premium member object
        $user->setEmail($f3->get('email'));


        if ($state == "--Select--") {
            $user->setState("");
        } else {
            $user->setState($f3->get('state'));
        }

        $user->setSeeking($f3->get('seeking'));
        $user->setBio($f3->get('bio'));

        // reroute to next page
        $f3->reroute('./interests');
    }


    // array from https://gist.github.com/maxrice/2776900
    $f3->set('stateNames', array('AL'=>'Alabama', 'AK'=>'Alaska', 'AZ'=>'Arizona',
        'AR'=>'Arkansas', 'CA'=>'California', 'CO'=>'Colorado', 'CT'=>'Connecticut',
        'DE'=>'Delaware', 'DC'=>'District of Columbia', 'FL'=>'Florida', 'GA'=>'Georgia',
        'HI'=>'Hawaii', 'ID'=>'Idaho', 'IL'=>'Illinois', 'IN'=>'Indiana',
        'IA'=>'Iowa', 'KS'=>'Kansas', 'KY'=>'Kentucky', 'LA'=>'Louisiana',
        'ME'=>'Maine', 'MD'=>'Maryland', 'MA'=>'Massachusetts', 'MI'=>'Michigan',
        'MN'=>'Minnesota', 'MS'=>'Mississippi', 'MO'=>'Missouri', 'MT'=>'Montana',
        'NE'=>'Nebraska', 'NV'=>'Nevada', 'NH'=>'New Hampshire', 'NJ'=>'New Jersey',
        'NM'=>'New Mexico', 'NY'=>'New York', 'NC'=>'North Carolina', 'ND'=>'North Dakota',
        'OH'=>'Ohio', 'OK'=>'Oklahoma', 'OR'=>'Oregon', 'PA'=>'Pennsylvania',
        'RI'=>'Rhode Island', 'SC'=>'South Carolina', 'SD'=>'South Dakota', 'TN'=>'Tennessee',
        'TX'=>'Texas', 'UT'=>'Utah', 'VT'=>'Vermont', 'VA'=>'Virginia',
        'WA'=>'Washington', 'WV'=>'West Virginia', 'WI'=>'Wisconsin', 'WY'=>'Wyoming',
    ));

    $template = new Template();
    echo $template->render('pages/profile.html');
});

// Define route for Interests Page
$f3->route('GET|POST /interests', function($f3) {

    $user = $_SESSION['user'];

    // skip interests page and reroute to summary page if regular member
    if(!$user instanceof PremiumMember) {
        $f3->reroute('./profile-summary');
    }

    // define indoor interests array
    $f3->set('indoorCheckboxes', array('tv', 'movies',
        'cooking', 'board games', 'puzzles', 'reading',
        'playing cards', 'video games'));

    // define outdoor interests array
    $f3->set('outdoorCheckboxes', array('hiking', 'biking',
        'swimming', 'collecting', 'walking', 'climbing'));

    if(isset($_POST['submit'])) {
        // Store post data in variables
        $userIndoorInterests = $_POST['indoorInterests'];
        $userOutdoorInterests = $_POST['outdoorInterests'];

        // include validation file
        include('models/data_validation.php');

        // define an empty array called $errors
        $errors = array();

        if(!validIndoor($userIndoorInterests)) {
            $errors['indoor'] = "Please only select valid indoor interests.";
        }

        if(!validOutdoor($userOutdoorInterests)) {
            $errors['outdoor'] = "Please only select valid outdoor interests.";
        }

        // Initialize a $success variable, true if $errors array is true, false otherwise
        $success = sizeof($errors) == 0;

        // set hive variables (used for sticky forms and displaying error messages)
        $f3->set('userIndoor', $userIndoorInterests);
        $f3->set('userOutdoor', $userOutdoorInterests);
        $f3->set('errors', $errors);

        // if no errors in forms
        if($success) {
            // set indoor and outdoor interests in premium member object
            $user->setInDoorInterests($f3->get('userIndoor'));
            $user->setOutDoorInterests($f3->get('userOutdoor'));

            // reroute to next page
            $f3->reroute('./profile-summary');
        }
    }

    $template = new Template();
    echo $template->render('pages/interests.html');
});

// Define route for Summary Page
$f3->route('GET|POST /profile-summary', function($f3) {

    $user = $_SESSION['user'];
    $src = 'profile-img.png';

    if($user instanceof PremiumMember) {
        $f3->set('interestsIn', $_SESSION['user']->getInDoorInterests());
        $f3->set('interestsOut', $_SESSION['user']->getOutDoorInterests());
    }

    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;

    if (isset($_POST['upload'])) {
        if(!empty($_FILES['fileToUpload'])) {
            $myfile = $_FILES['fileToUpload'];

            if($myfile['error'] > 0) {
                die('<div class="alert alert-danger" role="alert"> An error occurred while uploading the file </div>');
            }

            // allow only allow png, jpeg, and jpg extensions
            if ($imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "jpg") {
                echo "<p>Sorry, only png, jpeg, and jpg files allowed.</p>";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "<p>Sorry, your file was not uploaded.</p>";
            } else {
                // try to upload file
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'],
                    'images/'.$_FILES['fileToUpload']['name'])) {
                    $src = $_FILES['fileToUpload']['name'];
                    echo "<p>Your file successfully uploaded!</p>";
                } else {
                    echo "<p>There was a problem uploading your file - please try again.</p>";
                }
            }
        }

    }

    $f3->set('src', $src);

    $template = new Template();
    echo $template->render('pages/profile_summary.html');
});

// Run fat free
$f3->run();