<?php
 
// File saved as /path/to/custom/config.php

$s3_key = PluginData::where('plugin_slug', '=', 's3')->where('key', '=', 's3key')->first();
if(empty($s3_key->value)){
    $s3_key = '';
} else{
    $s3_key = $s3_key->value;
}

$s3_secret = PluginData::where('plugin_slug', '=', 's3')->where('key', '=', 's3secret')->first();
if(empty($s3_secret->value)){
    $s3_secret = '';
} else{
    $s3_secret = $s3_secret->value;
}
 
return array(
    // Bootstrap the configuration file with AWS specific features
    'includes' => array('_aws'),
    'services' => array(
        // All AWS clients extend from 'default_settings'. Here we are
        // overriding 'default_settings' with our default credentials and
        // providing a default region setting.
        'default_settings' => array(
            'params' => array(
                'key'    => $s3_key,
                'secret' => $s3_secret,
                'region' => 'us-east-1'
            )
        )
    )
);