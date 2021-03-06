<?php 
include("db.php"); 

include("admin/class.user.dao.php");
include("admin/class.driver.dao.php");
include("class.session.dao.php");

// functions..................................................................

function handleLogin() {

    //showLog("handleLogin");

    $ret = array('op' => 'login', 'msg'=> 'Login Successful', 'error_code'=> '0');

    $email     = $_POST["email"];
    $password  = $_POST["password"];

    $dao = new DAOuser();

    $user = $dao->getByEmailAndPassword($email, $password);

    if($user == NULL) {
        $ret["error_code"] = "1";
        $ret["msg"]        = "Invalid username or password";
    } else {
        $ret["uid"]        = $user->uid;
        $session_dao       = new DAOsession();
        $start_time        = date('Y-m-d H:i:s');
        $time              = time() + 3600;
        $end_time          = date('Y-m-d H:i:s',$time);
        $session_vo        = new session($ret["uid"],$start_time ,$end_time);
        $session_dao->save($session_vo);
        //$ret["session_code"] = $session_vo->session_code;
    
    }

    echo json_encode($ret);
}


function addCompany() {

    //showLog("handleLogin");

    $ret = array('op' => 'addcompany', 'msg'=> 'Company Added Successfully', 'error_code'=> '0');
    $session_dao       = new DAOsession();
    $session_dao->get($current_session);

    $dao = new DAOcompany();
    $vo = new company($_SESSION["uid"],$_POST["title"],$_POST["phone"],$_POST["city"],$_POST["state"],$_POST["pin_code"],$_POST["country"],$_POST["address"]);
    if(isset($_POST["comp_id"])){
        $vo->comp_id = $_POST["comp_id"];
    }
    $dao->save($vo);
    $comp = $dao->get($_SESSION["uid"]);

    if($comp == NULL) {
        $ret["error_code"] = "1";
        $ret["msg"]        = "Error Occured Or Company Not Created ";
    } else {
        $ret["comp_id"]        = $comp->comp_id;
    }

    echo json_encode($ret);
}


function handleRegister() {

    //showLog("handleLogin");
    //

    $ret = array('op' => 'register', 'msg'=> 'Registration Successful', 'error_code'=> '0');

    $username     = $_POST["username"];
    $email  = $_POST["email"];
    $password = $_POST["password"];
    $upass = md5(mysql_real_escape_string($_POST['password']));

    $dao = new DAOuser();

    // ensure that user with same email does not exist in database
    $user = $dao->getByEmail($email);

    // user already exists for give email
    if($user != NULL) {
        $ret["error_code"] = "1";
        $ret["msg"]        = "Email '" . $email . "' already exists";
        echo json_encode($ret);
        return;
    }

    // ensure that user with same username does not exist in database
    $user = $dao->getByUsername($username);

    // user already exists for give username
    if($user != NULL) {
        $ret["error_code"] = "1";
        $ret["msg"]        = "Username '" . $username . "' already exists";
        echo json_encode($ret);
        return;
    }

    $user = new user($_POST['username'], $upass, $_POST['email']);
    $dao->save($user);

    echo json_encode($ret);
}


////////////////////////////////////////////////////////////////////////////////////
//
//     DRIVER APIS
//
////////////////////////////////////////////////////////////////////////////////////

function handleGetDrivers() {
    $query = "select * from driver";
    $result = mysql_query($query);
    $ret = array();
    while( $row = mysql_fetch_assoc($result) ) {
        $ret[] = $row;
    }

    echo json_encode($ret);
}

function handleDriverLogin() {

    $username  = $_POST["username"];
    $password  = $_POST["password"];

    $ret = array('msg'=> 'Login Successful', 'error'=> '0');

    $result=mysql_query("SELECT * FROM driver WHERE username='$username' and password='$password'");
        
    if( mysql_num_rows($result) > 0 ) {
        $row = mysql_fetch_array($result);
        $ret["did"] = $row['did'];
    } else {
        $ret["error"] = 1;
        $ret["msg"] = "Invalid username or password";
    }

    echo json_encode($ret);
}

function addDriverLocation() {

    $did  = $_POST["did"];
    $lat  = $_POST["lat"];
    $lng  = $_POST["lng"];

    $ret = array('error'=> '0');

    $result = mysql_query("INSERT INTO driver_location(`did`,`lat`,`lng`) VALUES('$did', '$lat', '$lng')");

    if(! ($result > 0) ) {
        $ret["error"] = 1;
    }  

    echo json_encode($ret);
}

function getDriverLocations() {

    $did  = $_POST["did"];
    $lid  = $_POST["lid"];
    $query = "select * from driver_location where did=$did and lid > $lid limit 40";
    $result = mysql_query($query);
	
    $ret = array();
    while( $row = mysql_fetch_assoc($result) ) {
        $ret[] = $row;
    }

    echo json_encode($ret);
}

function handleGetMaxDriverLocation() {
    $did  = $_POST["did"];
    $ret = array("max_id" => 0);
    $result = mysql_query("SELECT MAX(lid) FROM driver_location where did=$did");
    $row = mysql_fetch_row($result);
    $ret["max_id"] = $row[0];
    echo json_encode($ret);
}



////////////////////////// MAIN ///////////////////////////////////////
if(!isset($_POST["op"]))  die("operation not specified");

$op = $_POST["op"];


// API handlers........................................................
if($op == "login")      handleLogin();
if($op == "register")   handleRegister();
if($op == "addcompany") addCompany();

// driver apis
if($op == "get_drivers")              handleGetDrivers();
if($op == "driver_login")             handleDriverLogin();
if($op == "add_driver_location")      addDriverLocation();
if($op == "get_driver_locations")     getDriverLocations();
if($op == "get_max_driver_location")  handleGetMaxDriverLocation();

?>
