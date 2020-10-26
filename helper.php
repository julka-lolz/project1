<?php
class helper{

	public function field_validation($fieldnames){

	/*
	
	checkt eerst of $fieldnames een array is. als het een array is, dan willen we geen error (=$error=False)
	Als er een error is (=$error=true), dan return false
	*/
	
		// heck hier of fieldnames een array is
		if(is_array($fieldnames)){

			// als het een array is, dan onderstaande.
			$error = False; //zolang error = false is het goed!

			foreach($fieldnames as $fieldname){
				echo $fieldname;
				if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){ 
					$error = True;
				}

			}

			if(!$error){ // not false returns true. we don't want any errors'
				return true;
			}

			return false;
		}else{
			return "Fieldnames must be an array";
		}
		
	}
}
?>