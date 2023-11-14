<?php
require_once('../config.php');



if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
if(!defined('DB_USERNAME')) define('DB_USERNAME',"root");
if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"");
if(!defined('DB_NAME')) define('DB_NAME',"imsdb");

class DBConnection{

    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    
    public $conn;
    
    public function __construct(){

        if (!isset($this->conn)) {
            
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if (!$this->conn) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
        
    }
    public function __destruct(){
        $this->conn->close();
    }
}

Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			if(isset($sql))
			$resp['sql'] = $sql;
			return json_encode($resp);
			exit;
		}
	}
	function save_appointment(){
		extract($_POST);
		$sched_set_qry = $this->conn->query("SELECT * FROM `schedule_settings`");
		$sched_set = array_column($sched_set_qry->fetch_all(MYSQLI_ASSOC),'meta_value','meta_field');
		$morning_start = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[0];
		$morning_end = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[1];
		$afternoon_start = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[0];
		$afternoon_end = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[1];
		$sched_time = date("Y-m-d ") . date("H:i",strtotime($date_sched));
		if(!in_array(strtolower(date("l",strtotime($date_sched))),explode(',',strtolower($sched_set['day_schedule'])))){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule Day of Week is invalid.";
			return json_encode($resp);
			exit;
		}
		if(!( (strtotime($sched_time) >= strtotime($morning_start) && strtotime($sched_time) <= strtotime($morning_end)) || (strtotime($sched_time) >= strtotime($afternoon_start) && strtotime($sched_time) <= strtotime($afternoon_end)) )){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule Time is invalid.";
			return json_encode($resp);
			exit;
		}
		$check = $this->conn->query("SELECT * FROM `appointments` where ('".strtotime($date_sched)."' Between unix_timestamp(date_sched) and unix_timestamp(DATE_ADD(date_sched, interval 30 MINUTE)) OR '".strtotime($date_sched.' +30 mins')."' Between unix_timestamp(date_sched) and unix_timestamp(DATE_ADD(date_sched, interval 30 MINUTE))) ".($id >0 ? " and id != '{$id}' " : ""))->num_rows;
		$this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule DateTime conflicts to other appointment.";
			return json_encode($resp);
			exit;
		}
		if(empty($patient_id))
		$sql = "INSERT INTO `patient_list` set name = '{$name}'  ";
		else
		$sql = "UPDATE `patient_list` set name = '{$name}' where id = '{$id}'  ";
		$save_inv = $this->conn->query($sql);
		$this->capture_err();
		if($save_inv){
			$patient_id = (empty($patient_id))? $this->conn->insert_id : $patient_id;
			if(empty($id))
			$sql = "INSERT INTO `appointments` set date_sched = '{$date_sched}',patient_id = '{$patient_id}',`status` = '{$status}',`couns_issue` = '{$couns_issue}' ";
			else
			$sql = "UPDATE `appointments` set date_sched = '{$date_sched}',patient_id = '{$patient_id}',`status` = '{$status}',`couns_issue` = '{$couns_issue}' where id = '{$id}' ";

			$save_sched = $this->conn->query($sql);
			$this->capture_err();
			$data = "";
			foreach($_POST as $k=> $v){
				if(!in_array($k,array('lid','date_sched','status','couns_issue'))){
					if(!empty($data)) $data .=", ";
					$data .= " ({$patient_id},'{$k}','{$v}')";
				}
			}
			$sql = "INSERT INTO `patient_meta` (patient_id,meta_field,meta_value) VALUES $data ";
			$this->conn->query("DELETE FROM `patient_meta` where patient_id = '{$patient_id}'");
			$save_meta = $this->conn->query($sql);
			$this->capture_err();
			if($save_sched && $save_meta){
				$resp['status'] = 'success';
				$resp['name'] = $name;
				$this->settings->set_flashdata('success',' Appointment successfully saved');
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "There's an error while submitting the data.";
			}

		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "There's an error while submitting the data.";
		}
		return json_encode($resp);
	}
	function multiple_action(){
		extract($_POST);
		if($_action != 'delete'){
			$stat_arr = array("pending"=>0,"confirmed"=>1,"cancelled"=>2);
			$status = $stat_arr[$_action];
			$sql = "UPDATE `appointments` set status = '{$status}' where patient_id in (".(implode(",",$ids)).") ";
			$process = $this->conn->query($sql);
			$this->capture_err();
		}else{
			$sql = "DELETE s.*,i.*,im.* from  `appointments` s inner join `patient_list` i on s.patient_id = i.id  inner join `patient_meta` im on im.patient_id = i.id where s.patient_id in (".(implode(",",$ids)).") ";
			$process = $this->conn->query($sql);
			$this->capture_err();
		}
		if($process){
			$resp['status'] = 'success';
			$act = $_action == 'delete' ? "Deleted" : "Updated";
			$this->settings->set_flashdata("success","Appointment/s successfully ".$act);
		}else{
			$resp['status'] = 'failed';
			$resp['error_sql'] = $sql;
		}
		return json_encode($resp);
	}
	function save_sched_settings(){
		$data = "";
		foreach($_POST as $k => $v){
			if(is_array($_POST[$k]))
			$v = implode(',',$_POST[$k]);
			if(!empty($data)) $data .= ",";
			$data .= " ('{$k}','{$v}') ";
		}
		$sql = "INSERT INTO `schedule_settings` (`meta_field`,`meta_value`) VALUES {$data}";
		if(!empty($data)){
			$this->conn->query("DELETE FROM `schedule_settings`");
			$this->capture_err();
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',' Schedule settings successfully updated');
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['msg'] = "An Error occure while excuting the query.";

		}
		return json_encode($resp);
	}
	
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_appointment':
		echo $Master->save_appointment();
	break;
	case 'multiple_action':
		echo $Master->multiple_action();
	break;
	case 'save_sched_settings':
		echo $Master->save_sched_settings();
		break;
	default:
		// echo $sysset->index();
		break;
}


class SystemSettings extends DBConnection{
	public function __construct(){
		parent::__construct();
	}
	function check_connection(){
		return($this->conn);
	}
	function load_system_info(){
		// if(!isset($_SESSION['system_info'])){
			$sql = "SELECT * FROM system_info";
			$qry = $this->conn->query($sql);
				while($row = $qry->fetch_assoc()){
					$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
				}
		// }
	}
	function update_system_info(){
		$sql = "SELECT * FROM system_info";
		$qry = $this->conn->query($sql);
			while($row = $qry->fetch_assoc()){
				if(isset($_SESSION['system_info'][$row['meta_field']]))unset($_SESSION['system_info'][$row['meta_field']]);
				$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
			}
		return true;
	}
	function update_settings_info(){
		$data = "";
		foreach ($_POST as $key => $value) {
			if(!in_array($key,array("about_us","privacy_policy")))
			if(isset($_SESSION['system_info'][$key])){
				$value = str_replace("'", "&apos;", $value);
				$qry = $this->conn->query("UPDATE system_info set meta_value = '{$value}' where meta_field = '{$key}' ");
			}else{
				$qry = $this->conn->query("INSERT into system_info set meta_value = '{$value}', meta_field = '{$key}' ");
			}
		}
		if(isset($_POST['about_us'])){
			file_put_contents('../about.html',$_POST['about_us']);
		}
		if(isset($_POST['privacy_policy'])){
			file_put_contents('../privacy_policy.html',$_POST['privacy_policy']);
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = 'uploads/'.strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'../'. $fname);
			if(isset($_SESSION['system_info']['logo'])){
				$qry = $this->conn->query("UPDATE system_info set meta_value = '{$fname}' where meta_field = 'logo' ");
				if(is_file('../'.$_SESSION['system_info']['logo'])) unlink('../'.$_SESSION['system_info']['logo']);
			}else{
				$qry = $this->conn->query("INSERT into system_info set meta_value = '{$fname}',meta_field = 'logo' ");
			}
		}
		if(isset($_FILES['cover']) && $_FILES['cover']['tmp_name'] != ''){
			$fname = 'uploads/'.strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../'. $fname);
			if(isset($_SESSION['system_info']['cover'])){
				$qry = $this->conn->query("UPDATE system_info set meta_value = '{$fname}' where meta_field = 'cover' ");
				if(is_file('../'.$_SESSION['system_info']['cover'])) unlink('../'.$_SESSION['system_info']['cover']);
			}else{
				$qry = $this->conn->query("INSERT into system_info set meta_value = '{$fname}',meta_field = 'cover' ");
			}
		}
		
		$update = $this->update_system_info();
		$flash = $this->set_flashdata('success','System Info Successfully Updated.');
		if($update && $flash){
			// var_dump($_SESSION);
			return true;
		}
	}
	function set_userdata($field='',$value=''){
		if(!empty($field) && !empty($value)){
			$_SESSION['userdata'][$field]= $value;
		}
	}
	function userdata($field = ''){
		if(!empty($field)){
			if(isset($_SESSION['userdata'][$field]))
				return $_SESSION['userdata'][$field];
			else
				return null;
		}else{
			return false;
		}
	}
	function set_flashdata($flash='',$value=''){
		if(!empty($flash) && !empty($value)){
			$_SESSION['flashdata'][$flash]= $value;
		return true;
		}
	}
	function chk_flashdata($flash = ''){
		if(isset($_SESSION['flashdata'][$flash])){
			return true;
		}else{
			return false;
		}
	}
	function flashdata($flash = ''){
		if(!empty($flash)){
			$_tmp = $_SESSION['flashdata'][$flash];
			unset($_SESSION['flashdata']);
			return $_tmp;
		}else{
			return false;
		}
	}
	function sess_des(){
		if(isset($_SESSION['userdata'])){
				unset($_SESSION['userdata']);
			return true;
		}
			return true;
	}
	function info($field=''){
		if(!empty($field)){
			if(isset($_SESSION['system_info'][$field]))
				return $_SESSION['system_info'][$field];
			else
				return false;
		}else{
			return false;
		}
	}
	function set_info($field='',$value=''){
		if(!empty($field) && !empty($value)){
			$_SESSION['system_info'][$field] = $value;
		}
	}
}
$_settings = new SystemSettings();
$_settings->load_system_info();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'update_settings':
		echo $sysset->update_settings_info();
		break;
	default:
		// echo $sysset->index();
		break;
}
?>