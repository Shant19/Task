<?php
class Controller {
	private $db;

	public function __construct() {
		$this->set_configs();
		if (isset($_POST['action'])) {
			$this->{$_POST['action']}($_POST['data']);
		}
	}

	private function set_configs() {
		$this->db = new mysqli('localhost', 'root', '', 'task');
	}

	private function valid_mail($email) {
		preg_match('/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,5})+$/', $email, $matches);
		return count($matches) ? true : false;
	}

	private function check_mail($data) {
		if(!$this->valid_mail($data)){
			echo json_encode(['error' => 'Invalid mail']);die;
		}
		$res = $this->db->query("SELECT token FROM users WHERE email='$data'")->fetch_all(true);
		$res = count($res) ? $res[0]['token'] : false;
		if($res) {
			echo json_encode(['message' => 'email already exist', 'token' => $res]);
		}else {
			$token = $this->generate_token($data);
			$res = $this->db->prepare("INSERT INTO users SET email=?, token=?");
			$res->bind_param("ss", $data, $token);
			$res->execute();
			$res->close();
			echo json_encode(['message' => 'email successfully added!', 'token' => $token]);
		}
	}

	private function check_token($token) {
		$res = $this->db->query("SELECT * FROM users WHERE token='$token'");

		return $res->num_rows;
	}

	private function add_info($data) {
		$data = stripcslashes($data);
		$data = json_decode($data);
		if (isset($data->name) && isset($data->surname) && isset($data->token)) {
			if(strlen($data->name) && strlen($data->surname) && $this->check_token($data->token)) {
				$res = $this->db->prepare("UPDATE users SET firstname=?, lastname=? WHERE token='$data->token'");
				$res->bind_param("ss", $data->name, $data->surname);
				$res->execute();
				$res->close();
				echo json_encode(['message' => 'Data successfully updated!']);die;
			}
		}

		echo json_encode(['error' => 'Invalid data']);
	}

	private function generate_token($email) {
		return md5($email . time());
	}
}

$controller = new Controller();