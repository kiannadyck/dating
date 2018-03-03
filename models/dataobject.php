<?php
    /*
        DROP TABLE IF EXISTS members;

        CREATE TABLE IF NOT EXISTS members
        (
            member_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            fname VARCHAR(50),
            lname VARCHAR(50),
            age TINYINT,
            gender VARCHAR(6),
            phone VARCHAR(12),
            email VARCHAR(50),
            member_state VARCHAR(30),
            seeking VARCHAR(6),
            bio TEXT,
            premium TINYINT(1),
            image_path VARCHAR(100),
            interests TEXT
        );
    */

    // database connection file
    require_once "/home/kdyckgre/config.php";

    /**
     * The DataObject class establishes a connection to the database.
     *
     * @author Kianna Dyck
     * @copyright 2018
     *
     */
    class DataObject
    {
        /**
         * DataObject constructor.
         */
        public function __construct()
        {

        }

        /**
         * This method establishes a connection with the database, using a PDO object.
         * @return PDO|void
         */
        function connect()
        {
            try {
                // instantiate PDO object
                $dbh = new PDO(DB_DSN,
                    DB_USERNAME,
                    DB_PASSWORD);
//        echo "Connected to database!";
                return $dbh;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return;
            }
        }

        /**
         * This method retrieves all the members currently stored in the database and returns the result.
         * @return array
         */
        function getMembers()
        {
            global $dbh;

            // 1. define the query
            $sql = "SELECT * FROM members ORDER BY lname";

            // 2. prepare the statement
            $statement = $dbh->prepare($sql);

            // 3. execute the statement
            $statement->execute();

            // 4. return the result
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        /**
         * This method adds a new member to the database.
         *
         * @param $fname First name of member
         * @param $lname Last name of member
         * @param $age Age of member
         * @param $phone Phone number of member
         * @param $gender Gender of member
         * @param $email Email of member
         * @param $state State member lives in
         * @param $seeking Gender of partner member is seeking romantically
         * @param $bio Biography of member
         * @param $isPremium Premium membership status of member
         * @param $interests Interests of member
         * @param $imagePath Path for an uploaded image
         * @return bool
         */
        function addMember($fname, $lname, $age, $phone, $gender, $email, $state, $seeking, $bio, $isPremium, $interests, $imagePath)
        {
            global $dbh;

            // 1. define the query
            $sql = "INSERT INTO members 
            (fname, lname, age, gender, phone, email, member_state, seeking, bio, premium, image_path, interests)
            VALUES
            (:fname, :lname, :age, :gender, :phone, :email, 
            :member_state, :seeking, :bio, :premium, :image_path, :interests);";

            // 2. prepare the statement
            $statement = $dbh->prepare($sql);

            // 3. bind parameters
            $statement->bindParam(':fname', $fname);
            $statement->bindParam(':lname', $lname);
            $statement->bindParam(':age', $age);
            $statement->bindParam(':gender', $gender);
            $statement->bindParam(':phone', $phone);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':member_state', $state);
            $statement->bindParam(':seeking', $seeking);
            $statement->bindParam(':bio', $bio);
            $statement->bindParam(':premium', $isPremium);
            $statement->bindParam(':interests', $interests);
            $statement->bindParam(':image_path', $imagePath);

            // 4. execute the statement
            $success = $statement->execute();

            // 5. return the result
            return $success;

        }

    }