<?php
//注意，请不要在这里配置SAE的数据库，配置你本地的数据库就可以了。
return array(
    //'配置项'=>'配置值'
    'SHOW_PAGE_TRACE'=>false,
    'URL_HTML_SUFFIX'=>'.html',
	
	//'配置项'=>'配置值'
	'APP_GROUP_LIST' => 'Index,Admin',
	'DEFAULT_GROUP'  =>  'Index',
	'App_GROUP_MODE' =>  1,
	'APP_GROUP_PATH' => 'Modules',

	'LOAD_EXT_CONFIG' => 'verify',

	'DB_HOST' => '127.0.0.1',
	'DB_USER' => 'root',
	'DB_PWD'  => 'root',
	'DB_NAME' => 'travelmanager',
	'DB_PREFIX' => 'tm_',

	//点语法默认解析
	'TMPL_VAR_IDENTIFY' => 'array',
);
?>