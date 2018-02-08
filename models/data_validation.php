<?php
/* Kianna Dyck
 * 02/03/2018
 * This file contains data validation functions.
 */
/**
 * Function checks to see that a string is all alphabetic
 * @param $name Name entered in the form by the client.
 * @return bool
 */
function validName($name)
{
    return !empty($name) && ctype_alpha($name);
}

/**
 * Function checks to see that an age is numeric and over 18.
 * @param $age Age entered in the form by the client.
 * @return bool
 */
function validAge($age)
{
    return !empty($age) && is_numeric($age) && $age >= 18;
}

/**
 * Function checks to see that a phone number is valid.
 * @param $phone Phone Number entered in the form by the client.
 * @return bool
 */
function validPhone($phone)
{
    $phoneLength = strlen($phone);
    if ($phoneLength == 10)
    {
        return is_numeric($phone);
    } else if ($phoneLength == 12){
        // check if there are two hyphens
        if (substr_count($phone, "-") == 2) {
            if ($phone[3] == "-" && $phone[7] == "-") {
                $phoneNumbers = explode("-", $phone);
                foreach($phoneNumbers as $numbers) {
                    if (!is_numeric($numbers)) {
                        return false;
                    }
                }
                return true;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }

}

/**
 * Function checks each selected outdoor interest against a list of valid options.
 * @param $interests Outdoor interests selected by client
 * @return bool
 */
function validOutdoor($interests)
{
    if (!empty($interests)) {
        global $f3;

        foreach ($interests as $interest) {
            if (!in_array($interest, $f3->get('outdoorCheckboxes'))) {
                return false;
            }
        }

        return true;
    }

    return true;
}

/**
 * Function checks each selected indoor interest against a list of valid options.
 * @param $interests Indoor interests selected by the client.
 * @return bool
 */
function validIndoor($interests)
{
    if (!empty($interests)) {
        global $f3;

        foreach ($interests as $interest) {
            if (!in_array($interest, $f3->get('indoorCheckboxes'))) {
                return false;
            }
        }

        return true;
    }

    return true;

}