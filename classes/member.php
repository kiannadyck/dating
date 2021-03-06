<?php

/**
 * The Member class represents a member of the dating application.
 *
 * The Member class represents a member with a first and last name,
 * age, gender, phone number, email, state, seeking, and biography.
 *
 * @author Kianna Dyck
 * @copyright 2018
 *
 */
class Member
    {
        // Declare attributes
        protected $fname;
        protected $lname;
        protected $age;
        protected $gender;
        protected $phone;
        protected $email;
        protected $state;
        protected $seeking;
        protected $bio;

        // Constructor
        function __construct($fname, $lname, $age, $gender, $phone)
        {
            $this->fname = $fname;
            $this->lname = $lname;
            $this->setAge($age);
            $this->setGender($gender);
            $this->phone = $phone;
        }

        // Getters and Setters

        /**
         * This method retrieves and returns the first name of the member.
         * @return String
         */
        public function getFname()
        {
            return $this->fname;
        }

        /**
         * This method sets the first name of the member to the given value.
         * @param String $fname The first name of the member.
         */
        public function setFname($fname)
        {
            $this->fname = $fname;
        }

        /**
         * This method retrieves and returns the last name of the member.
         * @return String
         */
        public function getLname()
        {
            return $this->lname;
        }

        /**
         * This method sets the last name of the member to the given value.
         * @param String $lname The last name of the member.
         */
        public function setLname($lname)
        {
            $this->lname = $lname;
        }

        /**
         * This method retrieves and returns the age of the member.
         * @return int
         */
        public function getAge()
        {
            return $this->age;
        }

        /**
         * This method sets the age of the member with the given value.
         * If the given age is not a numeric value or is a negative number,
         * the given age is considered bad input, and is replaced with null.
         * @param int $age The age of the member.
         */
        public function setAge($age)
        {
            // oldest human on record lived for 122 years.
            if(!is_numeric($age) || $age < 0 || $age > 122) {
                $age = NULL;
            }
            $this->age = $age;
        }

        /**
         * This method retrieves and returns the gender of the member.
         * @return String
         */
        public function getGender()
        {
            return $this->gender;
        }

        /**
         * This method sets the gender of the member to the given value.
         * If the given gender is not one of the available options, the
         * given gender is considered bad input, and is replaced with null.
         * @param String $gender The gender of the member.
         */
        public function setGender($gender)
        {
            $genders = array("Male", "Female");
            if(!in_array($gender, $genders)) {
                $gender = NULL;
            }
            $this->gender = $gender;
        }

        /**
         * This method retrieves and returns the phone number of the member.
         * @return String
         */
        public function getPhone()
        {
            return $this->phone;
        }

        /**
         * This method sets the phone number of the member to the given value.
         * @param String $phone The phone number of the member
         */
        public function setPhone($phone)
        {
            $this->phone = $phone;
        }

        /**
         * This method retrieves and returns the email of the member.
         * @return String
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * This method sets the email of the member to the given value.
         * If the given email is not a valid email, the email value is set
         * to null.
         * @param String $email The email of the member.
         */
        public function setEmail($email)
        {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = NULL;
            }
            $this->email = $email;
        }

        /**
         * This method retrieves and returns the state the member lives in.
         * @return String
         */
        public function getState()
        {
            return $this->state;
        }

        /**
         * This method sets the state of the member to the given value.
         * @param String $state The state the member lives.
         */
        public function setState($state)
        {
            $this->state = $state;
        }

        /**
         * This method retrieves and returns the gender the member desires for a romantic partner.
         * @return String
         */
        public function getSeeking()
        {
            return $this->seeking;
        }

        /**
         * This method sets the seeking of the member to the given value.
         * If the given gender for seeking is not one of the available options, the
         * given seeking gender is considered bad input, and is replaced with null.
         * @param String $seeking The gender the member interested in romantically.
         */
        public function setSeeking($seeking)
        {
            $genders = array("Male", "Female");
            if(!in_array($seeking, $genders)) {
                $gender = NULL;
            }

            $this->seeking = $seeking;
        }

        /**
         * This method retrieves and returns the biography of the member.
         * @return String
         */
        public function getBio()
        {
            return $this->bio;
        }

        /**
         * This method sets the bio of the member to the given value.
         * @param String $bio The biography of the member.
         */
        public function setBio($bio)
        {
            $this->bio = $bio;
        }

}