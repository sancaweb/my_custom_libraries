<?php
namespace Libraries;

class Rating {
    
    public function __construct(){
        
    }
	
	public function rating($rekom_yes,$total_rekom)
	{
	$rekom_yes=intval($rekom_yes);
	$total_rekom=intval($total_rekom);
	if($rekom_yes == 0 || $total_rekom==0 ){
		$ratenya=1;
	}else{
		$rating=intval(($rekom_yes/$total_rekom)*100);
	
	$rating_bulat=number_format($rating,0);
	
	if($rating_bulat >= 80 ){
		$ratenya="5";
	}elseif($rating_bulat >= 60 ){
		$ratenya="4";
	}elseif($rating_bulat >= 40 ){
		$ratenya="3";
	}elseif($rating_bulat >= 20 ){
		$ratenya="2";
	}else{
		$ratenya="1";
	}
	}
	
	
    return $ratenya;
	}
	
	
	
}