<?php
 	session_start();
 	date_default_timezone_set("Asia/Bangkok");

	$userId = "";
	$fullName = "";
	$credit = 0;

	// login
	if(isset($_GET['login'])) {
		$loginUserName = $_POST['username'];
		$loginPassword = $_POST['password'];

		include_once('db_connect.php');

		$sqlSelect = "SELECT user_id, full_name FROM user_info WHERE user_name = ? AND password = ? ";
		$stmt = $conn->prepare($sqlSelect);
		$stmt->bind_param("ss", $loginUserName, $loginPassword);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($row["user_id"], $row["full_name"]);
	    if($stmt->fetch()) {
			$userId = $row["user_id"];
			$fullName = $row["full_name"];

	        $sqlUpdate = "UPDATE user_info SET last_login_date = ? WHERE user_id = ?";
	        $stmt2 = $conn->prepare($sqlUpdate);
	        $now = date("Y-m-d H:i:s");
			$stmt2->bind_param("ss", $now, $row["user_id"]);
			$stmt2->execute();
			$stmt2->store_result();

			$sqlSelectCredit = "SELECT credit FROM user_credit WHERE user_id = ?";
			$stmt3 = $conn->prepare($sqlSelectCredit);
			$stmt3->bind_param("s", $row["user_id"]);
			$stmt3->execute();
			$stmt3->store_result();
			$stmt3->bind_result($rowCredit["credit"]);
		    if($stmt3->fetch()) {
		    	$credit = $rowCredit["credit"];
		    }
			$stmt3->close();
			echo $stmt2->affected_rows;
			$stmt2->close();


			$_SESSION['bacara_logined_user'] = array(
				'user_id' => $userId,
				'full_name' => $fullName
			);

			$_SESSION['bacara_user_credit'] = array(
				'credit' => $credit
			);
		}
		$stmt->close();
		$conn->close();

	// register
	} else if(isset($_GET['register'])) {
		$registerUsername = $_POST['username'];
		$registerPassword = $_POST['password'];
		$fullName = $_POST['fullname'];
		$mobilePhone = $_POST['mobilePhone'];
		$email = $_POST['email'];
		$lineId = $_POST['lineId'];

		include_once('db_connect.php');

		$sqlSelect = "SELECT user_id ";
		$sqlSelect .= "FROM user_info ";
		$sqlSelect .= "WHERE user_name = ? AND password = ?";
		$stmt = $conn->prepare($sqlSelect);
		$stmt->bind_param("ss", $registerUsername, $registerPassword);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($row['user_id']);
	    if($stmt->fetch()) {
			$userId = $row["user_id"];

	        $sqlUpdate = "UPDATE user_info SET full_name = ?, mobile_phone = ?, email = ?, line_id = ?, last_login_date = ? WHERE user_id = ?";
	        $stmt2 = $conn->prepare($sqlUpdate);
	        $now = date("Y-m-d H:i:s");
			$stmt2->bind_param("ssssss", $fullName, $mobilePhone, $email, $lineId, $now, $userId);
			$stmt2->execute();
			$stmt2->store_result();
			echo $stmt2->affected_rows;
			$stmt2->close();
		} else {
		    $sqlInsert = "INSERT user_info ";
		    $sqlInsert .= "(user_id, user_name, password, full_name, mobile_phone, email, line_id, create_date, last_login_date) ";
		    $sqlInsert .= "VALUES(?,?,?,?,?,?,?,?,?)";
	        $stmt2 = $conn->prepare($sqlInsert);
	        $userId = "";
	        for ($i = 0; $i<8; $i++) {
		   		$userId .= mt_rand(0,9);
    		}
	        $now = date("Y-m-d H:i:s");
			$stmt2->bind_param("sssssssss", $userId, $registerUsername, $registerPassword, $fullName, $mobilePhone, $email, $lineId, $now, $now);
			$stmt2->execute();
			$stmt2->store_result();

			$sqlSelect = "SELECT user_id, full_name FROM user_info WHERE user_name = ? AND password = ? ";
			$stmt3 = $conn->prepare($sqlSelect);
			$stmt3->bind_param("ss", $registerUsername, $registerPassword);
			$stmt3->execute();
			$stmt3->store_result();
			$stmt3->bind_result($row['user_id'], $row['full_name']);
			if($stmt3->fetch()) {
				$userId = $row["user_id"];
			}
			echo $stmt2->affected_rows;
			$stmt3->close();
			$stmt2->close();
		}

		$stmt->close();
		$conn->close();

		$_SESSION['bacara_logined_user'] = array(
			'user_id' => $userId,
			'full_name' => $fullName
		);

	// getCredit
	} if(isset($_GET['getCredit'])) {
		if(isset($_SESSION['bacara_logined_user'])) { 
			$loginedUser = $_SESSION['bacara_logined_user'];
			$userId = $loginedUser['user_id'];

			include_once('db_connect.php');

			$sqlSelectCredit = "SELECT credit FROM user_credit WHERE user_id = ?";
			$stmt = $conn->prepare($sqlSelectCredit);
			$stmt->bind_param("s", $userId);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($rowCredit["credit"]);
		    if($stmt->fetch()) {
		    	$credit = $rowCredit["credit"];
		    }
			$stmt->close();
			$conn->close();

			if ($credit >= 0) {
				$credit = $credit-1;
			}

			if ($credit >= 0) {
				$_SESSION['bacara_user_credit'] = array(
					'credit' => $credit
				);
			}

			echo $credit;

        }

	// useCredit
	} if(isset($_GET['useCredit'])) {
		if(isset($_SESSION['bacara_logined_user'])) { 
			$loginedUser = $_SESSION['bacara_logined_user'];
			$userId = $loginedUser['user_id'];

			include_once('db_connect.php');

			$sqlUpdate = "UPDATE user_credit SET credit = credit-1, update_date = ? WHERE user_id = ?";
	        $stmt = $conn->prepare($sqlUpdate);
	        $now = date("Y-m-d H:i:s");
			$stmt->bind_param("ss", $now, $userId);
			$stmt->execute();
			$stmt->store_result();
			$stmt->close();
			$conn->close();

			$userCredit = $_SESSION['bacara_user_credit'];
			$credit = $userCredit['credit'];
			echo $credit;
        }
	}
?>