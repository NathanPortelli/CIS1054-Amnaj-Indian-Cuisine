<?php

class Validate{

	public function validateStringR($string, $length){
		if(strlen($string) <= $length){
			if(!empty(trim($string))){
				if (preg_match("/^[a-zA-z]*$/", $string)) {
						return $string;
				}else{
					return "Invalid characters entered";
				}
				return "Empty field";
			}
		}else{
			return "Too many characters entered";
		}
	}

	public function validateString($string, $length){
		if(strlen($string) <= $length){
			if(!empty(trim($string))){
				if (preg_match("/^[a-zA-z]*$/", $string)) {
					return $string;
				}else{
					return "Invalid characters entered";
				}
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
		}
	}

	public function validateEmail($email){
		if(!empty(trim($email))){
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				return $email;
			}else{
				return "Invalid characters entered";
			}
		}else{
			return "Empty field";
		}
	}

	public function validatePasswordC($password, $cpassword){
		if(!empty($password)){
			if(strlen($password) < 8){
				return "Must be at least 8 characters long";
			}else if(strlen($password) > 20){
				return "Too many characters entered";
			}else{
				if(!preg_match("#[0-9]+#",$password)){
					return "Password must contain at least one number";
				}else if(!preg_match("#[A-Z]+#",$password)){
					return "Password must contain at least one lowercase letter";
				}else if(!preg_match("#[a-z]+#",$password)){
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