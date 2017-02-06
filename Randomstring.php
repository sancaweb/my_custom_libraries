<?php
namespace Libraries;

class Randomstring {
    
    public function __construct(){
        
    }
	
	public function randomstring($x)
	{
	$length=$x;
	$characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
	
	public function encode_angka($string){
			$string=$string;
		    $awalnya = array("0","1","2","3","4","5","6","7","8","9","-");
			$gantinya =array("H","J","K","L","M","N","P","Q","R","S","T");
			$hasilnya = str_replace($awalnya, $gantinya, $string);
    return $hasilnya;
	}
	
	public function decode_angka($string){
			$string=$string;
		    $awalnya = array("H","J","K","L","M","N","P","Q","R","S","T");
			$gantinya =array("0","1","2","3","4","5","6","7","8","9","-");
			$hasilnya = str_replace($awalnya, $gantinya, $string);
    return $hasilnya;
	}
	
	
}