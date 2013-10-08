<?php
Class CommonAction extends Action{
	Public function _initialize(){
		//验证是否登录 todo
		if(!isset($_SESSION[C('USER_AUTH_KEY')])){
			$this->redirect(GROUP_NAME . '/Login/index');
		}

		$noAuth = in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE'))) || in_array(ACTION_NAME, explode(',', C('NOT_AUTH_ACTION')));
//		echo ACTION_NAME;
		if(C('USER_AUTH_ON') && !$noAuth){
			import("ORG.Util.RBAC");
			RBAC::AccessDecision(GROUP_NAME) || $this->error("没有权限");
		}
	} 
}
?>