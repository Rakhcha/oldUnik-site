<?php
	// skins_directory - путь к папке со скинами относительно расположения этого файла
	// default - файл со скином по умолчанию
	// user - имя скина(файла со скином)
	// type - тип скина - steve/alex
	// size - размер выходящего изображения по ширине
	// mode: 1 - полностью (голова, руки, ноги, тело) спереди; 2 - полностью сзади; 3- голова
	// URL по типу: /skin.php?mode=1&size=100&user=Rakhcha&type=alex
	$generator_info = array(
		'skins_directory' => __DIR__.'/../../../img/skins/',
		'default' => 'unikdefault_skin_user',
		'user' => filter_input(INPUT_GET,'user',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
		'type' => filter_input(INPUT_GET,'type',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
		'size' => filter_input(INPUT_GET,'size',FILTER_SANITIZE_NUMBER_FLOAT),
		'mode' => filter_input(INPUT_GET,'mode',FILTER_SANITIZE_NUMBER_FLOAT),
	);
	
	if (!is_dir($generator_info['skins_directory'])) exit('EROOR SKIN_01 Путь к скинам или плащам не является папкой! Укажите правильный путь.');
	if(empty($generator_info['user'])) $generator_info['user'] = 'unikdefault_skin_user';
	if(empty($generator_info['type'])) $generator_info['type'] = 'steve';

	if (file_exists($generator_info['skins_directory'].$generator_info['user'].'.png')) $generator_info['skin'] = $generator_info['skins_directory'].$generator_info['user'].'.png';
	else $generator_info['skin'] = $generator_info['skins_directory'].$generator_info['default'].'.png';

	if (empty($generator_info['size'])) $generator_info['size'] = '128';
	if (empty($generator_info['mode'])) $generator_info['mode'] = '1';

	$generator_info['image_size'] = getimagesize($generator_info['skin']);
	$generator_info['width'] = $generator_info['image_size']['0'];
	$generator_info['height'] = $generator_info['image_size']['1'];

	header ("Content-type: image/png");

	$generator_info['skin_image'] = imagecreatefrompng($generator_info['skin']);

	if ($generator_info['mode'] == '3') $generator_info['image'] = imagecreatetruecolor(8, 8);
	else $generator_info['image'] = imagecreatetruecolor(16, 32);

	imagefill($generator_info['image'], 0, 0, imagecolorallocatealpha($generator_info['image'], 255, 255, 255, 127));

	switch($generator_info['mode']){
		case '1':
			fullface($generator_info['image'], $generator_info['skin_image'], $generator_info['height'], $generator_info['type']);
			break;
		case '2':
			fullback($generator_info['image'], $generator_info['skin_image'], $generator_info['height'], $generator_info['type']);
			break;
		case '3':
			steve_head($generator_info['image'], $generator_info['skin_image'], $generator_info['height']);
			break;
	}

	if ($generator_info['mode'] == '3' ) $generator_info['finale_image'] = imagecreatetruecolor($generator_info['size'],$generator_info['size']);
	else $generator_info['finale_image'] = imagecreatetruecolor($generator_info['size'],$generator_info['size']*2);

	imagesavealpha($generator_info['finale_image'], true);
	imagefill($generator_info['finale_image'], 0, 0, imagecolorallocatealpha($generator_info['finale_image'], 255, 255, 255, 127));

	imagecopyresized($generator_info['finale_image'], $generator_info['image'], 0, 0, 0, 0, imagesx($generator_info['finale_image']), imagesy($generator_info['finale_image']), imagesx($generator_info['image']), imagesy($generator_info['image']));

	imagepng($generator_info['finale_image']);
	imagedestroy($generator_info['finale_image']);
	imagedestroy($generator_info['image']);
	imagedestroy($generator_info['skin_image']);

	function fullface($image, $skin_image, $height, $type){
		imagecopy($image, $skin_image, 4, 0, 8, 8, 8, 8);
		imagecopy($image, $skin_image, 4, 0, 40, 8, 8, 8);

		imagecopy($image, $skin_image, 4, 8, 20, 20, 8, 12);
		if($height == 64) imagecopy($image, $skin_image, 4, 8, 20, 36, 8, 12);
		
		arms_fullface($image, $skin_image, $height, $type);
		
		imagecopy($image, $skin_image, 4, 20, 4, 20, 4, 12);
		if($height == 64){
			imagecopy($image, $skin_image, 4, 20, 4, 36, 4, 12);
			imagecopy($image, $skin_image, 8, 20, 20, 52, 4, 12);
			imagecopy($image, $skin_image, 8, 20, 4, 52, 4, 12);
		} else imagecopy($image, $skin_image, 8, 20, 4, 20, 4, 12);
	};

	function fullback($image, $skin_image, $height, $type){

		imagecopy($image, $skin_image, 4, 0, 24, 8, 8, 8);
		imagecopy($image, $skin_image, 4, 0, 56, 8, 8, 8);

		imagecopy($image, $skin_image, 4, 8, 32, 20, 8, 12);
		if($height == 64) imagecopy($image, $skin_image, 4, 8, 32, 36, 8, 12);

		arms_fullback($image, $skin_image, $height, $type);

		imagecopy($image, $skin_image, 4, 20, 12, 20, 4, 12);
		if($height == 64){
			imagecopy($image, $skin_image, 4, 20, 12, 36, 4, 12);
			imagecopy($image, $skin_image, 8, 20, 28, 52, 4, 12);
			imagecopy($image, $skin_image, 8, 20, 12, 52, 4, 12);
		} else imagecopy($image, $skin_image, 8, 20, 12, 20, 4, 12);
	};

	function steve_head($image, $skin_image, $height){

		imagecopy($image, $skin_image, 0, 0, 8, 8, 8, 8);
		imagecopy($image, $skin_image, 0, 0, 40, 8, 8, 8);
	};

	function arms_fullface($image, $skin_image, $height, $type){

		if($type == 'steve'){
			imagecopy($image, $skin_image, 0, 8, 44, 20, 4, 12);
			if($height == 64){
				imagecopy($image, $skin_image, 0, 8, 44, 36, 4, 12);
				imagecopy($image, $skin_image, 12, 8, 36, 52, 4, 12);
				imagecopy($image, $skin_image, 12, 8, 52, 52, 4, 12);
			} else imagecopy($image, $skin_image, 12, 8, 44, 20, 4, 12);
		} else {
			imagecopy($image, $skin_image, 1, 8, 44, 20, 3, 12);
			if($height == 64){
				imagecopy($image, $skin_image, 1, 8, 44, 36, 3, 12);
				imagecopy($image, $skin_image, 12, 8, 36, 52, 3, 12);
				imagecopy($image, $skin_image, 12, 8, 52, 52, 3, 12);
			} else imagecopy($image, $skin_image, 12, 8, 44, 20, 3, 12);
		}
	}

	function arms_fullback($image, $skin_image, $height, $type){

		if($type == 'steve'){
			imagecopy($image, $skin_image, 12, 8, 52, 20, 4, 12);
			if($height == 64){
				imagecopy($image, $skin_image, 12, 8, 52, 36, 4, 12);
				imagecopy($image, $skin_image, 0, 8, 44, 52, 4, 12);
				imagecopy($image, $skin_image, 0, 8, 60, 52, 4, 12);
			} else imagecopy($image, $skin_image, 0, 8, 52, 20, 4, 12);
		} else {
			imagecopy($image, $skin_image, 12, 8, 51, 20, 3, 12);
			if($height == 64){
				imagecopy($image, $skin_image, 12, 8, 51, 36, 3, 12);
				imagecopy($image, $skin_image, 1, 8, 43, 52, 3, 12);
				imagecopy($image, $skin_image, 1, 8, 59, 52, 3, 12);
			} else imagecopy($image, $skin_image, 1, 8, 51, 20, 3, 12);
		}
	}
