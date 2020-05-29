<?php

class Validate{
	public function validateString($string, $length, $strict = false){
		if(strlen($string) <= $length){
			if(!empty(trim($string))){
				$regex = "/^[a-zA-z -]*$/";

				if ($strict){
					$regex = "/^[a-zA-z]*$/";
				}

				if (preg_match($regex, $string)) {
					return $string;
				}else{
					return "Invalid characters entered";
				}
			} else {
				return "Empty field";
			}
		}else{
			return "Too many characters entered";
		}
	}

	public function validateInt($int, $length){
		if(strlen($int) <= $length){
			if(!empty(trim($int))){
				if (preg_match("/[0-9]*$/", $int)) {
					return $int;
				}else{
					return "Invalid characters entered";
				}
			} else {
				return "Empty field";
			}
		}else{
			return "Too many characters entered";
		}
	}

	public function validateDouble($d, $length){
		if(strlen($d) <= $length){
			if(!empty(trim($d))){
				if (preg_match("/[0-9]+\.+[0-9]*$/", $d)) {
					return $d;
				}else{
					return "Invalid characters entered";
				}
			} else {
				return "Empty field";
			}
		}else{
			return "Too many characters entered";
		}
	}

	public function validateArea($string, $length){
		if(!empty($string)){
			if(strlen($string) <= $length){
				return $string;
			}else{
				return "Too many characters entered";
			}
		} else {
			return "Empty field";
		}
	}

	public function validateEmail($email){
		if(!empty(trim($email))){
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				return $email;
			}else{
				return "Invalid email";
			}
		}else{
			return "Empty field";
		}
	}

	public function validatePasswordC($password, $cpassword){
		if(!empty($password)){
			if(strlen($password) < 8){
				return "Password must be at least 8 characters long";
			}else if(strlen($password) > 20){
				return "Password too long (max 20)";
			}else{
				echo "Password: ".$password;
				if(!preg_match_all("/[0-9]/",$password)){
					return "Password must contain at least one number";
				}else if(!preg_match_all("/[A-Z]/",$password)){
					return "Password must contain at least one uppercase letter";
				}else if(!preg_match_all("/[a-z]/",$password)){
					return "Password must contain at least one lowercase letter";
				}else{
					if($password !== $cpassword){
						return "Passwords do not match";
					}else{
						return $password;
					}
				}
			}
		}else{
			return "Empty field";
		}
	}
}