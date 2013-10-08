<?php

	class PersonalCenterAction extends CommonAction{
		public function resetPwd(){
			$this->display();
		}

		/**
		 *	修改用户密码
		 */
		public function resetPwdHandle(){
			$username = session("username");

			$db = M('user');
			$user = $db->where(array('username' => $username))->find();
			if(!$user || $user['password'] != I('old_pwd','', 'md5')){
				$this->error("旧密码错误！");
			}else{
				$user['password'] = I('new_pwd', '', 'md5');
				$db->save($user);
				$this->success("密码修改成功！");
			}
		}

		/** 个人资料显示 */
		public function selfInfo(){
			$username = session("username");

			$db = M('user');
			$this->user = $db->where(array('username' => $username))->find();
			$this->display();
		}

		public function updateSelfInfo(){
			$username = session("username");

			$db = M('user');
			$user["nickname"] = I("nickname");
			$user["phone"] = I("phone");
			if($db->where(array('username' => $username, ))->save($user)){
				$this->error("保存成功");
			}else{
				$this->success("保存失败！");
			}
		}

	}
?>