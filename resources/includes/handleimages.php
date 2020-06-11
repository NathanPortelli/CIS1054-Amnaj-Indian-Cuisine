<?php

class HandleImages{
	public function upload($pName, $pTempName, $pSize, $pError, $directory){
		$pExtArr = explode('.', $pName);
		$pExt = strtolower(end($pExtArr));

		$allowedExts = array('jpg', 'jpeg', 'png', 'webp');

		if(in_array($pExt, $allowedExts)){
			if($pError === 0){
				if($pSize < 1024*1024*1024){
					$dest = dirname(__DIR__).'/images/'.$directory.'/'.$pName;
					$uCheck = move_uploaded_file($pTempName, $dest);
					if(!$uCheck){
						return "Upload Error";
					}else{
						$dest = 'resources/images/'.$directory.'/'.$pName;
						return $dest;
					}
				}else{
					return "File too big";
				}
			}else{
				return "Upload Error";
			}
		}else{
			return "Invalid file extension";
		}
	}
}