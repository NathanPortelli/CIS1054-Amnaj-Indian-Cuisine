<?php

if(isset($_POST['login'])){//making sure access to this page was granted from the form
	require '../../dbwrapper.php';//database connection module
	$db = new Db();

	$email = $_POST['email'];
	$password = $_POST['password'];

	if(empty($email) || empty($password)){
		header("Location: ../../signin.php?error=emptyFields");//checking for signing in
		exit();

	}else{
		$sql = $db->select("SELECT * FROM users WHERE email=".$db->quote($email));

		if(!$sql){//checking for possible database errors when signing in
			header("Location: ../../signin.php?error=noUser");//user does not exist
			exit();

		}else{
			$passCheck = password_verify($password, $sql[0]['pword']);//checking to see if password matches hashed version

			if($passCheck == false){
				header("Location: ../../signin.php?error=incorrectPassword");
				exit();

			}else if($passCheck == true){//uses if else just incase website messes up, just because the password check was not false does not mean it is true if there was some error, this is for security

				session_start();//creating the logged in session
				$_SESSION['id'] = $sql[0]['id'];
				$_SESSION['email'] = $sql[0]['email'];
				$_SESSION['name'] = $sql[0]['name'];
				$_SESSION['surname'] = $sql[0]['surname'];
				$_SESSION['usergroup'] = $sql[0]['usergroup'];

				header("Location: ../../index.php?login=success");
				exit();

			}else{
				header("Location: ../../signin.php?error=incorrectPassword");
				exit();
			}	
		}
	}

}else{
	header("Location: ../../index.php");
	exit();
}