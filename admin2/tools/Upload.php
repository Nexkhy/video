<?php 

class Upload {
	

	public function __construct() {
	}






	public function extensions_autorisees_image($extension) {
		$tab= array('.png', '.PNG', '.jpg', '.JPG', '.jpeg', '.JPEG', 
			        '.gif', '.GIF');

		return in_array($extension, $tab);
	}



	public function size_autorisees_image($size) {
		if($size >  2097152) { //2 Mo
			return false;
		}
		return true;
	}



	public function width_autorisees_image($width, $width_autorisee) {
		if($width >  $width_autorisee) {
			return false;
		}
		return true;
	}



	public function height_autorisees_image($height, $height_autorisee) {
		if($height > $height_autorisee) {
			return false;
		}
		return true;
	}



	public function dimension_autorisees_image($width, $height, 
		            $width_autorisee, $height_autorisee) {
		if($width >  $width_autorisee || $height > $height_autorisee) {
			return false;
		}
		return true;
	}



	public function resize_image($file_source, $extension, $width, $height, 
		            $width_autorisee, $height_autorisee, $destination) {
		$image_choisie= null;
		$new_width= null;
		$new_height= null;
		$new_image= null;
		$test= true;

		//--------------------------------------------------------------------------
		//imagecreatefromjpeg permet de creer une copie de l'image
		
		if(strtolower($extension) == '.jpg' || strtolower($extension) == '.jpeg') {
			$image_choisie= imagecreatefromjpeg($file_source);
		}
		elseif(strtolower($extension) == '.png') {
			$image_choisie= imagecreatefrompng($file_source);
		}
		elseif(strtolower($extension) == '.gif') {
			$image_choisie= imagecreatefromgif($file_source);
		}
		else {
			$test= false;
		}

		//----------------------------------------------------------------------
		//Reduction de la taille de l'image

		if($image_choisie != null) {
			if($this->width_autorisees_image($width, $width_autorisee) == false) {
				$reduction= $width_autorisee / $width;
				$new_width= $width * $reduction;
				$new_height= $height * $reduction;
			}
			elseif($this->height_autorisees_image($height, $height_autorisee) == false) {
				$reduction= $height_autorisee / $height;
				$new_width= $width * $reduction;
				$new_height= $height * $reduction;
			}
		}
		else {
			$test= false;
		}


		//----------------------------------------------------------------------
		//Creer une nouvelle image

		if($new_width != null && $new_height != null) {
			$new_image= imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($new_image , $image_choisie, 0, 0, 0, 0, $new_width, 
				               $new_height, $width, $height);
			imagedestroy($image_choisie);
		}
		else {
			$test= false;
		}


		//----------------------------------------------------------------------
		//Enregistrer la nouvelle image

		if($new_image != null) {
			if(strtolower($extension) == '.jpg' || strtolower($extension) == '.jpeg') {
				imagejpeg($new_image, $destination);
			}
			elseif(strtolower($extension) == '.png') {
				imagepng($new_image, $destination);
			}
			elseif(strtolower($extension) == '.gif') {
				imagegif($new_image, $destination);
			}
		}
		else {
			$test= false;
		}
		

		//-----------------------------------------------------------------------
		return $test;
	}














	public function extensions_autorisees_file($extension) {
		$tab= array('.pdf', '.PDF', '.doc', '.DOC', '.docx', '.DOCX', 
			        '.rft', '.RFT');

		return in_array($extension, $tab);
	}

	public function size_autorisees_file($size) {
		if($size >  10485760) { //10 Mo
			return false;
		}
		return true;
	}

	





	

	public function uploaded($source, $destination) {
		return move_uploaded_file($source, $destination);
	}


	public function rename($prefix, $separateur, $extension) {
		$str= $prefix . $separateur . date('dmYHis') . rand(1, 1000) . $extension;

		return $str;
	}








	public function upload_image($file, $prefix, $width_limit, $height_limit, $path_folder) {

		$file_name= $file['name'];
	    $file_type= $file['type'];
	    $file_tmp_name= $file['tmp_name'];
	    $file_error= $file['error'];
	    $file_size= $file['size'];

	    $file_extension= strtolower(strrchr($file_name, "."));
	    $file_width= getimagesize($file_tmp_name)[0];
	    $file_height= getimagesize($file_tmp_name)[1];


	    $file_dest= $this->rename($prefix, '-', $file_extension);
	    $dest= $path_folder . $file_dest;


	    if($this->dimension_autorisees_image($file_width, $file_height,
	                                     $width_limit, $height_limit)) {
	        $this->uploaded($file_tmp_name, $dest);
	    }
	    else {
	        $resize= $this->resize_image($file_tmp_name, $file_extension, $file_width, 
	                            $file_height, $width_limit, $height_limit, 
	                            $dest);
	    }

	    return $file_dest;
	}	






	public function upload_file($file, $prefix, $path_folder) {
		$file_name= $file['name'];
	    $file_type= $file['type'];
	    $file_tmp_name= $file['tmp_name'];
	    $file_error= $file['error'];
	    $file_size= $file['size'];

	    $file_extension= strtolower(strrchr($file_name, "."));

	    $file_dest= $this->rename($prefix, '-', $file_extension);
	    $dest= $path_folder . $file_dest;


	    $this->uploaded($file_tmp_name, $dest);

	    return $file_dest;
	}






}

?>