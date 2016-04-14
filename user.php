<?php
interface UserDao extends Dao{
    public function getUserByEmail($email);
    public function getUserBySurname($surname);
}

class UserDaoImpl implements UserDao{
    
    private $db_Connector;
    
    function _contruct(){
        //empty constructor
    }

    public function getDb_Connector(){
        if($this->db_Connector == NULL){
            $this->db_Connector = DBConnector::getConnector();
        }
        return $this->db_Connector;
    }
    
    public function create($user) {

        $firstName = strtolower($user->getFirstName());
        $lastName = strtolower($user->getLastName());
        $midName = strtolower($user->getMidName());
        $password = $user->getPassword();
        $email = strtolower($user->getEmail());
        $userName = strtolower($user->getUserName());

        $hash = $user->getHash();
        $active = $user->getActive();
        $name = strtolower($user->getName());
        $facebook_id = $user->getFaceBookId();
        $facebook_Link = $user->getFaceBookLink();
        $phone_no = $user->getPhoneNo();
        $phone_code = $user->getPhoneCode();
        $date_of_bith = $user->getDateOfBirth();
        $time_stamp = $user->getTimeStamp();

        /*$sql = "INSERT INTO users (first_name, last_name, mid_name, pass_word, email, user_name)
                VALUES ('$firstName','$lastName','$midName','$password','$email','$userName')";*/
        $conn = $this->getDb_Connector();
        
        $stmt = $conn->prepare("INSERT INTO users (first_name, mid_name, last_name,user_name ,pass_word,
                        hash, active, email, full_name, facebook_id, facebook_link, phone_no, date_of_birth, time_stamp, phone_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("ssssssissssssss", $firstName, $midName, $lastName, $userName, $password,
            $hash, $active, $email, $name, $facebook_id, $facebook_Link, $phone_no, $date_of_bith, $time_stamp, $phone_code);
        //echo 'before execute';
        $stmt->execute();
        //echo 'After execute';
        $stmt->close();
        $conn->close();

        //echo 'Insert Successful';
    }
    
    public function get($id) {
        $conn = $this->getDb_Connector();
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        
        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = new User();
        
        while ($row = $result->fetch_assoc()) {
            $user->setId($row["id"]);
            $user->setFirstName($row["first_name"]);
            $user->setLastName($row["last_name"]);
            $user->setMidName($row["mid_name"]);
            $user->setPassword($row["pass_word"]);
            $user->setEmail($row["email"]);
            $user->setUserName($row["user_name"]);

            $user->setHash($row["hash"]);
            $user->setActive($row["active"]);
            $user->setName($row["full_name"]);
            $user->setFaceBookId($row["facebook_id"]);
            $user->setFaceBookLink($row["facebook_link"]);
            $user->setPhoneNo($row["phone_no"]);
            $user->setDateOfBirth($row["date_of_birth"]);
            $user->setTimeStamp($row["time_stamp"]);
            $user->setPhoneCode($row["phone_code"]);
        }
       
        $stmt->close();
        $conn->close();

        return $user;
    }
    
    public function update($user) {
       $id = $user->getId();
       $firstName = strtolower($user->getFirstName());
       $lastName = strtolower($user->getLastName());
       $midName = strtolower($user->getMidName());
       $password = strtolower($user->getPassword());
       $email = strtolower($user->getEmail());
       $userName = strtolower($user->getUserName());

        $hash = $user->getHash();
        $active = $user->getActive();
        $full_name = strtolower($user->getName());
        $facebook_id = $user->getFaceBookId();
        $facebook_Link = $user->getFaceBookLink();
        $phone_no = $user->getPhoneNo();
        $phone_code = $user->getPhoneCode();
        $date_of_birth = $user->getDateOfBirth();
        $time_stamp = $user->getTimeStamp();



       
       $conn = $this->getDb_Connector();

       
       $stmt = $conn->prepare("UPDATE users SET first_name = ?, mid_name = ?,
                        last_name = ?, user_name = ?, pass_word = ?, hash = ?, active = ?,
                        email = ?, full_name = ?, facebook_id = ?, facebook_link = ?, phone_no = ?,
                        date_of_birth = ?, time_stamp = ?, phone_code = ? WHERE id = ?");


        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("ssssssissssssssi", $firstName, $midName, $lastName, $userName, $password, $hash, $active,
                            $email, $full_name, $facebook_id, $facebook_Link, $phone_no, $date_of_birth, $time_stamp, $phone_code ,$id);
        $stmt->execute();

        $stmt->close();
        $conn->close();
        
        echo 'Update Successful';
    }
    
    public function delete($user) {
        $id = $user->getId();
       
        $conn = $this->getDb_Connector();

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        
        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        echo "Record deleted successfully";
    }
    
    public function count() {
        $conn = $this->getDb_Connector();
       
        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        $no_of_records = 0;
        while ($row = $result->fetch_assoc()) {
            $no_of_records = $no_of_records + 1; 
        }
        return $no_of_records;
    }
    
    public function exist($id) {
        $conn = $this->getDb_Connector();
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        
        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $val = 0;
        while ($row = $result->fetch_assoc()) {
            $val = $val + 1;
        }
       
        $stmt->close();
        $conn->close();
        
        if ($val> 0) {
            return TRUE;  
        } else {
            return FALSE;
        }
    }
    
    public function getUserByEmail($email) {
        $conn = $this->getDb_Connector();
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        
        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = new User();
        
        while ($row = $result->fetch_assoc()) {
            $user->setId($row["id"]);
            $user->setFirstName($row["first_name"]);
            $user->setLastName($row["last_name"]);
            $user->setMidName($row["mid_name"]);
            $user->setPassword($row["pass_word"]);
            $user->setEmail($row["email"]);
            $user->setUserName($row["user_name"]);

            $user->setHash($row["hash"]);
            $user->setActive($row["active"]);
            $user->setName($row["full_name"]);
            $user->setFaceBookId($row["facebook_id"]);
            $user->setFaceBookLink($row["facebook_link"]);
            $user->setPhoneNo($row["phone_no"]);
            $user->setDateOfBirth($row["date_of_birth"]);
            $user->setTimeStamp($row["time_stamp"]);
            $user->setPhoneCode($row["phone_code"]);
        }
       
        //$stmt->close();
        //$conn->close();

        return $user;
    }
    
    public function getUserBySurname($lastname) {
       $conn = $this->getDb_Connector();
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE last_name = ? LIMIT 1");
        
        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("s", $lastname);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = new User();
        
        while ($row = $result->fetch_assoc()) {
            $user->setId($row["id"]);
            $user->setFirstName($row["first_name"]);
            $user->setLastName($row["last_name"]);
            $user->setMidName($row["mid_name"]);
            $user->setPassword($row["pass_word"]);
            $user->setEmail($row["email"]);
            $user->setUserName($row["user_name"]);

            $user->setHash($row["hash"]);
            $user->setActive($row["active"]);
            $user->setName($row["full_name"]);
            $user->setFaceBookId($row["facebook_id"]);
            $user->setFaceBookLink($row["facebook_link"]);
            $user->setPhoneNo($row["phone_no"]);
            $user->setDateOfBirth($row["date_of_birth"]);
            $user->setTimeStamp($row["time_stamp"]);
            $user->setPhoneCode($row["phone_code"]);
        }
       
        $stmt->close();
        $conn->close();
        
        return $user;
    }

    public function getUserByFaceBookId($facebook_id) {
        $conn = $this->getDb_Connector();

        $stmt = $conn->prepare("SELECT * FROM users WHERE facebook_id = ? LIMIT 1");

        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("s", $facebook_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = new User();

        while ($row = $result->fetch_assoc()) {
            $user->setId($row["id"]);
            $user->setFirstName($row["first_name"]);
            $user->setLastName($row["last_name"]);
            $user->setMidName($row["mid_name"]);
            $user->setPassword($row["pass_word"]);
            $user->setEmail($row["email"]);
            $user->setUserName($row["user_name"]);

            $user->setHash($row["hash"]);
            $user->setActive($row["active"]);
            $user->setName($row["full_name"]);
            $user->setFaceBookId($row["facebook_id"]);
            $user->setFaceBookLink($row["facebook_link"]);
            $user->setPhoneNo($row["phone_no"]);
            $user->setDateOfBirth($row["date_of_birth"]);
            $user->setTimeStamp($row["time_stamp"]);
            $user->setPhoneCode($row["phone_code"]);
        }

        //$stmt->close();
        //$conn->close();

        return $user;
    }
    
    public function getAll() {
        $users = array();
        
        $conn = $this->getDb_Connector();
        
        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        
        
        while ($row = $result->fetch_assoc()) {
            $user = new User();
            $user->setId($row["id"]);
            $user->setFirstName($row["first_name"]);
            $user->setLastName($row["last_name"]);
            $user->setMidName($row["mid_name"]);
            $user->setPassword($row["pass_word"]);
            $user->setEmail($row["email"]);
            $user->setUserName($row["user_name"]);

            $user->setHash($row["hash"]);
            $user->setActive($row["active"]);
            $user->setName($row["full_name"]);
            $user->setFaceBookId($row["facebook_id"]);
            $user->setFaceBookLink($row["facebook_link"]);
            $user->setPhoneNo($row["phone_no"]);
            $user->setDateOfBirth($row["date_of_birth"]);
            $user->setTimeStamp($row["time_stamp"]);
            $user->setPhoneCode($row["phone_code"]);

            $users[] = $user;
        }
       
        $stmt->close();
        $conn->close();

        return $users;
    }



    public function getUserByEmailAndPassWord($email, $password) {
        $conn = $this->getDb_Connector();
        $active = 1;

        //$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND pass_word = ? AND active = ? LIMIT 1");

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND pass_word = ? LIMIT 1");

        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = new User();

        while ($row = $result->fetch_assoc()) {
            $user->setId($row["id"]);
            $user->setFirstName($row["first_name"]);
            $user->setLastName($row["last_name"]);
            $user->setMidName($row["mid_name"]);
            $user->setPassword($row["pass_word"]);
            $user->setEmail($row["email"]);
            $user->setUserName($row["user_name"]);

            $user->setHash($row["hash"]);
            $user->setActive($row["active"]);
            $user->setName($row["full_name"]);
            $user->setFaceBookId($row["facebook_id"]);
            $user->setFaceBookLink($row["facebook_link"]);
            $user->setPhoneNo($row["phone_no"]);
            $user->setDateOfBirth($row["date_of_birth"]);
            $user->setTimeStamp($row["time_stamp"]);
            $user->setPhoneCode($row["phone_code"]);
        }

        $stmt->close();
        $conn->close();

        return $user;
    }


    public function getUserByEmailAndHash($email, $hash) {
        $conn = $this->getDb_Connector();
        $active = 1;

        //$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND hash = ? AND active = ? LIMIT 1");

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND hash = ? LIMIT 1");

        //The argument may be one of four types: i - integer, d - double, s - string, b - BLOB
        $stmt->bind_param("ss", $email, $hash);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = new User();

        while ($row = $result->fetch_assoc()) {
            $user->setId($row["id"]);
            $user->setFirstName($row["first_name"]);
            $user->setLastName($row["last_name"]);
            $user->setMidName($row["mid_name"]);
            $user->setPassword($row["pass_word"]);
            $user->setEmail($row["email"]);
            $user->setUserName($row["user_name"]);

            $user->setHash($row["hash"]);
            $user->setActive($row["active"]);
            $user->setName($row["full_name"]);
            $user->setFaceBookId($row["facebook_id"]);
            $user->setFaceBookLink($row["facebook_link"]);
            $user->setPhoneNo($row["phone_no"]);
            $user->setDateOfBirth($row["date_of_birth"]);
            $user->setTimeStamp($row["time_stamp"]);
            $user->setPhoneCode($row["phone_code"]);
        }

        //$stmt->close();
        //$conn->close();

        return $user;
    }


}

class UserService{
    private $userDao;
    
    function __construct() {
        if($this->userDao == NULL){
            $this->userDao = new UserDaoImpl();
        }
    }
    
    public function createUser($user){
        $this->userDao->create($user);
    }
    
    public function updateUser($user){
        $this->userDao->update($user);
    }
    
    public function deleteUser($user){
        $this->userDao->delete($user);
    }
    
    public function getUser($id){
        return $this->userDao->get($id);
    }
    
    public function countUsers(){
        return $this->userDao->count();
    }
    
    public function exist($id){
        return $this->userDao->exist($id);
    }
    
    public function getAllUsers(){
        return $this->userDao->getAll();
    }
    
    public function getUserByEmail($email){
        return $this->userDao->getUserByEmail($email);
    }
    
    public function getUserBySurname($surname){
        return $this->userDao->getUserBySurname($surname);
    }

    public function  getUserByEmailAndPassWord($email, $password){
        return $this->userDao->getUserByEmailAndPassWord($email, $password);
    }

    public function  getUserByEmailAndHash($email, $hash){
        return $this->userDao->getUserByEmailAndHash($email, $hash);
    }

    public function  getUserByFaceBookId($facebook_id){
        return $this->userDao->getUserByFaceBookId($facebook_id);
    }

}

class User{
    private $id;
    private $firstName;
    private $lastName;
    private $midName;
    private $password;
    private $email;
    private $userName;

    /*Added member variables*/
    private $name;
    private $faceBookId;
    private $faceBookLink;
    private $phoneNo;
    private $dateOfBirth;
    private $timeStamp;
    private $phoneCode;
    private $active;
    private $hash;

    
    function __construct() {
        
    }
    
    public function getId() {
        return $this->id; 
    }
    
    public function setId($id) {
        $this->id = $id; 
    }
    
    public function getFirstName() {
        return $this->firstName;
    }
    
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    
    public function getLastName() {
        return $this->lastName;
    }
    
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    
    public function getMidName() {
        return $this->midName;
    }
    
    public function setMidName($midName) {
        $this->midName = $midName;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getUserName() {
        return $this->userName;
    }
    
    public function setUserName($userName) {
        $this->userName = $userName;
    }

    /* Added properties below */

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getFaceBookId() {
        return $this->faceBookId;
    }

    public function setFaceBookId($faceBookId) {
        $this->faceBookId = $faceBookId;
    }

    public function getFaceBookLink() {
        return $this->faceBookLink;
    }

    public function setFaceBookLink($faceBookLink) {
        $this->faceBookLink = $faceBookLink;
    }

    public function getPhoneNo() {
        return $this->phoneNo;
    }

    public function setPhoneNo($phoneNo) {
        $this->phoneNo = $phoneNo;
    }

    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getTimeStamp() {
        return $this->phoneNo;
    }

    public function setTimeStamp($timeStamp) {
        $this->timeStamp = $timeStamp;
    }

    public function getPhoneCode() {
        return $this->phoneCode;
    }

    public function setPhoneCode($phoneCode) {
        $this->phoneCode = $phoneCode;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getHash() {
        return $this->hash;
    }

    public function setHash($hash) {
        $this->hash = $hash;
    }
}