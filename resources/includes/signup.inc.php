<?php
if(isset($_POST['signup'])){//making sure user was redirected from the sign up form
	require '../../dbwrapper.php';
	$db = new Db();

	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$cpassword = $_POST['confirmpassword'];

	if(empty($name) ||empty($surname)||empty($email)||empty($password)||empty($cpassword)){//data validation along with checking for empty fields
		// return redirect('../../signup.html')->with(['error'=>"Please fill in all fields"]);
		header("Location: ../../signup.php?error=emptyFields");
		exit();
	}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../../signup.php?error=invalidEmail");
		exit();
	}elseif (!preg_match("/^[a-zA-Z]*$/", $name)) {
		header("Location: ../../signup.php?error=invalidName");
		exit();
	}elseif (!preg_match("/^[a-zA-Z]*$/", $surname)) {
		header("Location: ../../signup.php?error=invalidSurname");
		exit();
	}else if (strlen($_POST["password"]) <= '8') {
        header("Location: ../../signup.php?error=invalidPasswordLen");
		exit();
    }elseif(!preg_match("#[0-9]+#",$password)) {
        header("Location: ../../signup.php?error=invalidPasswordNum");
		exit();
    }elseif(!preg_match("#[A-Z]+#",$password)) {
        header("Location: ../../signup.php?error=invalidPasswordUC");
		exit();
    }elseif(!preg_match("#[a-z]+#",$password)) {
         header("Location: ../../signup.php?error=invalidPasswordLC");
		exit();

	}elseif ($password !== $cpassword) {
		header("Location: ../../signup.php?error=passwordCheck");
		exit();
	}
	else{
		$sql = $db->select("SELECT email FROM users WHERE email=".$db->quote($email));

		if($sql === true){
			header("Location: ../../signin.php?error=EmailAlreadyUsed&email=".$email);
			exit();
		}else{	
			$hashedpword = password_hash($password, PASSWORD_DEFAULT);	

			$sqlAdd = $db->query("INSERT INTO users (email, pword, name, surname) VALUES (".$db->quote($email).", ".$db->quote($hashedpword).", ".$db->quote($name).", ".$db->quote($surname).")");
				
			header("Location: ../../signin.php");
			exit();
		}
	}


}else{
	header("Location: ../../signup.php");
	exit();
}