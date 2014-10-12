<?php

class Plugins {

	public static function get_plugins() {

		$plugins = array();
		$plugin_folder = 'content/plugins';

		$plugins_dir = @ opendir( $plugin_folder);
		$plugin_files = array();
		
		if ( $plugins_dir ) {
			
			while (($folder = readdir( $plugins_dir ) ) !== false ) {

				if( is_readable("$plugin_folder/$folder/index.blade.php") && is_readable("$plugin_folder/$folder/info.json") ){
					$plugin_info = file_get_contents("$plugin_folder/$folder/info.json");
					$plugin_info = json_decode($plugin_info, true);
					$plugin_info['slug'] = $folder;
					array_push($plugins, $plugin_info);
				}

			}

			closedir( $plugins_dir );
		}

		return $plugins;
	}

	public static function get_plugin($slug){

		$plugin_folder = 'content/plugins';

		if( is_readable("$plugin_folder/$slug/index.blade.php") && is_readable("$plugin_folder/$slug/info.json") ){
			$plugin_info = file_get_contents("$plugin_folder/$slug/info.json");
			$plugin_info = json_decode($plugin_info, true);
			$plugin_info['slug'] = $slug;
		}

		return $plugin_info;
	}

}