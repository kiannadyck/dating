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
$f3->route('POST /profile', function() {
    $template = new Template();
    echo $template->render('pages/profile.html');
});

// Define route for Interests Page
$f3->route('POST /interests', function($f3) {

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
    $template = new Template();
    echo $template->render('pages/profile_summary.html');
});

// Run fat free
$f3->run();