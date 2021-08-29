<?php
class DBManager{
    private $conn;
    function __construct(){
        $this->conn=new MySQLi;
    }
    function __destruct(){
        if(!$this->conn->connect_error){
            $this->conn->close();
        }
    }

    function connect($host,$uname,$upass,$dbname){
        @$this->conn->connect($host,$uname,$upass,$dbname);
	    if($this->conn->connect_errno){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }

    function mysqli_error(){
        return $this->conn->error;
    }

    function select_db($new_dbname){
        @$this->conn->select_db($new_dbname);
        if($this->conn->error){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }


    function select_query($sql){
        $res=$this->conn->query($sql);
        if($res->num_rows>0){
            if(method_exists($this->conn,"fetch_all")){
                $values = $res->fetch_all(MYSQLI_ASSOC);
                return $values;
            }
            else{
                $rows=array();
                while($row=$res->fetch_assoc()){
                    $rows[]=$row;
                }
                return $rows;
            }
        }
        else{
            return FALSE;

        }
    }

    function select_query_with_row($sql){
        $res=$this->conn->query($sql);
		
        if($res->num_rows==1){
            $values = $res->fetch_assoc();
            return $values;
        }
        else{
            return FALSE;

        }
    }

    function select_query_with_rows($sql){
        $res=$this->conn->query($sql);
        if($res->num_rows>0){
            $rows=array();
            while($row=$res->fetch_assoc()){
                $rows[]=$row;
            }
            return $rows;
        }
        else{
            return FALSE;

        }
    }
     function count_query($sql){
        $res=$this->conn->query($sql);
        $values=$res->num_rows;
        return $values;

    }

    function insert_query($sql){
        $res=$this->conn->query($sql);
        if($res){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function update_query($sql){
        $res=$this->conn->query($sql);
        if($res){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function insert_query_last($sql){

        $res=$this->conn->query($sql);
        if($res){
            $test=$this->conn->insert_id;
            return $test;
        }
        else{
            return FALSE;
        }
    }


    function delete_query($sql){
        $res=$this->conn->query($sql);
        if($res){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function removeQuote($input){
        $input=str_replace('"','\"',$input);
        $input=str_replace("'","\'",$input);
        return $input;
    }

    function WebAdminLogin($user,$pass){
       $sql="SELECT * FROM `".DB_PREFIX."_admin` WHERE (`web_username`='".$user."' AND `web_password`='".$pass."')";
        $res=$this->conn->query($sql);
        if($res->num_rows==1){ 
            $row=$res->fetch_assoc();
            $_SESSION['webadmin_id']=$row['web_id'];
            $_SESSION['webadmin_username']=$row['web_username'];
           return TRUE; 
        }
        else{
            return FALSE;
        }
    }
    

    function chkAuth($user,$pass){
        $sql="SELECT * FROM `".DB_PREFIX."_admin` WHERE (`web_username`='".$user."' AND `web_password`='".$pass."')";
		
        $res=$this->conn->query($sql);
        if($res->num_rows==1){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

   
	
		
     function send($to,$from,$subject,$mail_body,$name){		
         
		require_once ($_SERVER["DOCUMENT_ROOT"]."/dev/cutech_training/smtp/PHPMailerAutoload.php");		
    
        $mail = new PHPMailer;

        $mail->isSendmail();

        $mail->SMTPDebug = 2;

        $mail->Debugoutput = 'html';

        $mail->Host = "smtp.ionos.com";

        $mail->setFrom($from, '');

        $mail->addAddress($to, $name);

        $mail->Subject =$subject; 

        $mail->msgHTML($mail_body);
	

        if (!$mail->send()) {
          return FALSE;
        } else {
           return TRUE;
        }
    }

}

$searchReplaceArray = array(
    '$' => '%24',
    '&' => '%26',
    '+'=>'%2B',
    ','=>'%2C',
    '/'=>'%2F',
    ':'=>'%3A',
    ';'=>'%3B',
    '='=>'%3D',
    '?'=>'%3F',
    "\'"=>'%27',
    "'"=>'%27',
    '"'=>'%93',
    '‘'=>'%91',
    '”'=>'%94',
    '’'=>'%92',
    '<'=>'%3C',
    '>'=>'%3E',
    '-'=>'%u2212;'
);

$ReplaceArray = array(
    '%24' => '$',
    '%26' => '&',
    '%2B'=>'+',
    '%2C'=>',',
    '%2F'=>'/',
    '%3A'=>':',
    '%3B'=>';',
    '%3D'=>'=',
    '%3F'=>'?',
    '%27'=>"\'",
    '%27'=>"'",
    '%93'=>'"',
    '%91'=>'‘',
    '%94'=>'”',
    '%92'=>'’',
    '%3C'=>'<',
    '%3E'=>'>',
	'%u2212;'=>'-'
);

function get_symbol($symbol)
{
    global $ReplaceArray; global $searchReplaceArray;
    return $rslt=str_replace(array_keys($ReplaceArray),array_values($ReplaceArray),$symbol);
}

function get_entity($symbol)
{
    global $ReplaceArray; global $searchReplaceArray;
    return $rslt=str_replace(array_keys($searchReplaceArray),array_values($searchReplaceArray),$symbol);
}
function validate_image($upload){
   $array_image=array("image/jpeg","image/jpg","image/png","image/gif");
   $array_img_ext=array("jpeg","jpg","png","gif");
$parts=explode(".",$upload["name"]);
 
   if (in_array($upload["type"], $array_image) && in_array($parts[1], $array_img_ext))
   {
       return true;
   }
   else{
       return false;
   }
}
?>