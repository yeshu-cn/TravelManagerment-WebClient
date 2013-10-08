<?php

	return array(
		//超级管理员名词
		'RBAC_SUPERADMIN' => 'admin',
		'ADMIN_AUTH_KEY'  => 'superadmin', //超级管理员识别
		'USER_AUTH_ON'    => true, //是否开启验证
		'USER_AUTH_TYPE' => 1, //验证类型（1：登录验证 2：实时验证）
		'USER_AUTH_KEY' => 'uid', //用户认证识别号
		'NOT_AUTH_MODULE' => 'Index',	//无需认证的控制器
		'NOT_AUTH_ACTION' => 'updateGroupHandle,updateGroupDetail,deleteGroupHandle,logout,addGroupHandle,addGuideHandle,updateGuideHandle,deleteGuideHandle,dispatchGuideHandle, dispatchGuideDetail,resetPwdHandle',	//无需认证的动作方法
		'RBAC_ROLE_TABLE' => 'tm_role',	//角色表名称
		'RBAC_USER_TABLE' => 'tm_role_user', //角色与用户的中间表名称
		'RBAC_ACCESS_TABLE' => 'tm_access',
		'RBAC_NODE_TABLE' => 'tm_node',

		'TMPL_PARSE_STRING' => array(
			'__PUBLIC__' => __ROOT__ . '/' .APP_NAME . '/Modules/' . GROUP_NAME . 
			'/Tpl/Public'
		),

		'URL_HTML_SUFFIX' => '',
		//打开调试功能
//		'SHOW_PAGE_TRACE' => 'true',
	);
?>