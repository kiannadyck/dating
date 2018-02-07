<?php
/*
 * Kianna Dyck
 * 01/19/2018
 * This is the controller for my dating website.
 */

// Require the autoload file
require_once('vendor/autoload.php');

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
$f3->route('GET /personal-info', function() {
    $template = new Template();
    echo $template->render('pages/personal_info.html');
});

// Define route for profile Page
$f3->route('POST /profile', function($f3) {
    print_r($_POST);
    // Array ( [firstName] => Sarah
    // [lastName] => Smith
    // [age] => 30
    // [gender] => Female
    // [phone] => 222-333-4444
    // [submit] => Next > )

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
$f3->route('POST /interests', function($f3) {
    print_r($_POST);
    // Array ( [email] => my_email@gmail.com
    // [state] => Alaska
    // [seeking] => Female
    // [bio] => jsklfjsdlfjsdfkljsdkljf
    // [submit] => Next > )

    // define indoor interests array
    $f3->set('indoorCheckboxes', array('tv', 'movies',
        'cooking', 'board games', 'puzzles', 'reading',
        'playing cards', 'video games'));

    // define outdoor interests array
    $f3->set('outdoorCheckboxes', array('hiking', 'biking',
        'swimming', 'collecting', 'walking', 'climbing'));

    $template = new Template();
    echo $template->render('pages/interests.html');
});

// Define route for Summary Page
$f3->route('POST /profile-summary', function() {
    print_r($_POST);
    // Array ( [indoorInterests] => Array ( [0] => tv [1] => reading )
    // [outdoorInterests] => Array ( [0] => biking ) [submit] => Next > )

    $template = new Template();
    echo $template->render('pages/profile_summary.html');
});

// Run fat free
$f3->run();