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

	public function validateInt($int, $length, $extended = false){
		if(strlen($int) <= $length){
			if(!empty(trim($int))){
				$regex = "/[^0-9]/";

				if ($extended){
					$regex = "/[^0-9+:\- ]/";
				}

				if (preg_match($regex, $int)) {
					return "Invalid characters entered";
				}else{
					return $int;
				}
			} else {
				return "Empty field";
			}
		}else{
			return "Too many characters entered";
		}
	}

	public function validateDouble($double, $length){
		if(strlen($double) <= $length){
			if(!empty(trim($double))){
				if (preg_match("/[^0-9.]/", $double) || preg_match("/[.].*[.]/", $double)) {
					return "Invalid characters entered";
				}else{
					if (doubleval($double) < 0){
						return "Number is smaller than 0";
					} else {
						return $double;
					}
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