<?php

$s3_url = PluginData::where('plugin_slug', '=', 's3')->where('key', '=', 's3url')->first();
if(empty($s3_url->value)){
	$s3_url = '';
} else{
	$s3_url = $s3_url->value;
}

Config::set('site.media_upload_function', 's3upload');
Config::set('site.uploads_dir', $s3_url);

use Aws\Common\Aws;
//use Aws\S3\S3Client;


function s3upload($args){


	$image = $args['image'];
	$folder = $args['folder'];
	$filename = $args['filename']; 
	$type = $args['type'];


	if($folder == 'images'){
		$month_year = date('FY').'/';
	} else {
		$month_year = '';
	}

	$upload_folder = 'content/uploads/' . $folder . '/'.$month_year;

	if ( @getimagesize($image) ){

		// if the folder doesn't exist then create it.
		if (!file_exists($upload_folder)) {
			mkdir($upload_folder, 0777, true);
		}

		if($type =='upload'){

			$filename =  $image->getClientOriginalName();

			// if the file exists give it a unique name
			while (file_exists($upload_folder.$filename)) {
				$filename =  uniqid() . '-' . $filename;
			}


			$uploadSuccess = $image->move($upload_folder, $filename);

			if(strpos($filename, '.gif') > 0){
				$new_filename = str_replace('.gif', '-animation.gif', $filename);
				copy($upload_folder . $filename, $upload_folder . $new_filename);
			}

		} else if($type = 'url'){
			
			$file = file_get_contents($image);

			if(strpos($image, '.gif') > 0){
				$extension = '-animation.gif';
			} else {
				$extension = '.jpg';
			}

			$filename = $filename . $extension;

			if (file_exists($upload_folder.$filename)) {
				$filename =  uniqid() . '-' . $filename . $extension;
			}

		    if(strpos($image, '.gif') > 0){
				file_put_contents($upload_folder.$filename, $file);
				$filename = str_replace('-animation.gif', '.gif', $filename);
			}

		    file_put_contents($upload_folder.$filename, $file);

		}
	   
	
		$settings = Setting::first();

		$img = Image::make($upload_folder . $filename);

		if($folder == 'images'){
			$img->resize(700, null, true);
		} else if($folder == 'avatars'){
			$img->resize(200, 200, false);
		}

		if($settings->enable_watermark && $folder == 'images'){
			$img->insert(Config::get('site.uploads_dir') . '/settings/' . $settings->watermark_image, $settings->watermark_offset_x, $settings->watermark_offset_y, $settings->watermark_position);
			$img->save($upload_folder . $filename);
		} else {
			$img->save($upload_folder . $filename);
		}

		// Move the file to s3 bucket
		moveToS3($upload_folder, $filename, $folder, $month_year);

		// remove from local after we have uploaded to s3
		unlink($upload_folder . $filename);

		return $month_year . $filename;

	} else {
		return false;
	}

}

function moveToS3($upload_folder, $filename, $folder, $month_year){

	$s3_bucket = PluginData::where('plugin_slug', '=', 's3')->where('key', '=', 's3bucket')->first();
	if(empty($s3_bucket->value)){
		$s3_bucket = '';
	} else{
		$s3_bucket = $s3_bucket->value;
	}
	
	$config_location = getcwd() . '/content/plugins/s3/s3config.php';
	// Instantiate an S3 client
	$aws = Aws::factory( $config_location );
	$s3 = $aws->get('s3');

	$sourceFile = $upload_folder . $filename;
	$key = $folder . '/' . $month_year . $filename;

	// Upload a publicly accessible file.
	// The file size, file type, and MD5 hash are automatically calculated by the SDK
	try {
	    $s3->putObject(array(
	        'Bucket' => $s3_bucket,
	        'Key'    => $key,
	        'SourceFile' => $sourceFile,
	        'ACL'    => 'public-read',
	    ));
	} catch (S3Exception $e) {
	    echo "There was an error uploading the file.\n";
	}

}