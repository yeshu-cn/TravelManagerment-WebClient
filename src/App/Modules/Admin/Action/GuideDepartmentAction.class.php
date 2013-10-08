<?php
	class GuideDepartmentAction extends CommonAction{
		public function addGuide(){
			$this->display();
		}

		public function manageGuide(){
			//获取user表中角色为导游的用户
			$this->guides = D('UserGuideRelation')->field('password', true)->relation(true)->select();
			$this->display();
		}

		public function dispatchGuide(){
			$this->groups = M('tourgroup')->select();
			$this->display();
		}

		/**
		 * 录入导游，只录入昵称不知道行不行
		 */
		public function addGuideHandle(){
			$guide = array(
				'username' => "guide" . time(),
				'nickname' => I('name'),
				'phone' => I('phone'),
				'password' => I('name', '', 'md5'),
				'logintime' => time(),
				'loginip' => get_client_ip(),
			);

			$guide_role_id = M("role")->where(array('name' => '导游'))->getField('id');

			if($uid = M('user')->add($guide)){
				$role = array(
						'role_id' => $guide_role_id,
						'user_id' => $uid
						);

				M('role_user')->add($role);

				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}

		public function updateGuide(){
			$this->id = I('id');
			$this->nickname = I('username');
			$this->phone = I('phone');
			$this->display();
		}

		/**
		 *	处理修改导游信息操作
		 */
		public function updateGuideHandle(){
			  // 需要更新的数据
    		$data['phone'] = I('phone');

    		// 更新的条件
    		$condition['id'] = I('id', -1, 'intval');
    		if(M('user')->where($condition)->save($data)){
    			$this->success('修改成功', U(GROUP_NAME. '/GuideDepartment/manageGuide'));
    		}else{
    			$this->error('修改失败');
    		}
		}

		/**
		 *	处理删除 导游信息操作
		 */
		public function deleteGuideHandle(){
			$condition['id'] = I('id', -1, 'intval');
			if(M('user')->where($condition)->delete()){
    			$this->success('删除成功', U(GROUP_NAME. '/GuideDepartment/manageGuide'));
    		}else{
    			$this->error('删除失败');
    		}
		}

		/**
		 *	进入排团页面
		 */
		public function dispatchGuideDetail(){
			$this->users = D('UserGuideRelation')->field('password', true)->relation(true)->select();
			$this->target = M('tourgroup')->where(array('id' => I('id')))->find();
			$this->display();
		}

		/**
		 *	处理排团操作
		 */
		public function dispatchGuideHandle(){
			$data['guides'] = implode(' ',I('guides'));
			$condition['id'] = I('id');
			if(M('tourgroup')->where($condition)->save($data)){
				$this->success('排团成功', U(GROUP_NAME . "/GuideDepartment/dispatchGuide"));
			}else{
				$this->error('排团失败');
			}
		}
	}
?>