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
						return 3;
					}else{
						$dest = 'resources/images/'.$directory.'/'.$pName;
						return $dest;
					}
				}else{
					return 2;
				}
			}else{
				return 1;
			}
		}else{
			return 0;
		}
	}
}