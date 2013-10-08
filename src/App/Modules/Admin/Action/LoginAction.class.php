<?php

	Class LoginAction extends Action{
		Public function index(){
			$this->display();
		}

		Public function verify(){

			//框架自带的验证码
			import('ORG.Util.Image');
			Image::buildImageVerify();

			// //后盾网提供的验证码库
			// echo APP_PATH;
			// import('Class.Image', APP_PATH, '.php');
			// Image::verify();
		}

		//登录表单操作
		Public function login(){
			if(!IS_POST){
				halt('页面不存在');
			}
				
			//sae平台特殊处理验证码
			if(md5(strtoupper($_POST['code']))!=$_SESSION['verify']){
    			//验证错误处理代码
    			$this->error('验证码错误');
 			}


			// if(I('code', '', 'strtolower') != session('verify')){
			// 	$this->error('验证码错误');
			// }

			$db = M('user');
			$user = $db->where(array('username' => I('username')))->find();

			if(!$user || $user['password'] != I('password', '', 'md5')){
				$this->error('username or password wrong!');
			}

			//更新最后一次登录时间与IP
			$data = array(
				'id' => $user['id'],
				'logintime' => time(),
				'loginip' => get_client_ip(),
				);
			$db->save($data);

			session(C('USER_AUTH_KEY'), $user['id']);
			session('username', $user['username']);
			session('logintime', date('Y-m-d H:i:s', $user['logintime']));
			session('loginip', $user['loginip']);

			//超级管理员识别
			if($user['username'] == C('RBAC_SUPERADMIN')){
				session(C('ADMIN_AUTH_KEY'), true);
			}

			// p($_SESSION);
			//读取用户权限
			import('ORG.Util.RBAC');
			RBAC::saveAccessList();
			redirect(__GROUP__);
		}

		public function logout(){
			session_unset();
			session_destroy();
			$this->redirect(GROUP_NAME . "/Login/index");
		}
	}



?>