<?php

class GeneralManagerAction extends CommonAction{

	/**
	 * 审核录入和修改的团队信息
	 * @return [type] [description]
	 */
	public function checkGroupInfo(){
		$map['audittype']  = array('in','0, 1');
		$this->groups = M('tourgroup')->where($map)->select();
		$this->display();
	}

	public function checkGroupInfoDetail(){
		$this->target = M('tourgroup')->where(array('id' => I('id')))->find();
		$this->display();
	}

	public function deleteGroup(){
		$condition['id'] = I('id', -1, 'intval');
		if(M('tourgroup')->where($condition)->delete()){
			$this->success('删除成功', U(GROUP_NAME. '/GeneralManager/manageGroups'));
		}else{
			$this->error('删除失败');
		}
	}

	/**
	 * 团队信息管理,只显示已审核的团队信息
	 * @return [type] [description]
	 */
	public function manageGroups(){
		$condition["audittype"] = 2;
		$this->groups = M("tourgroup")->where($condition)->select();
		$this->display();
	}


	public function userList(){
		$this->user = D('UserRelation')->field('password', true)->relation(true)->select();
		$this->display();
	}

	public function addUser(){
		$this->role = M('role')->select();
		$this->display();
	}

	public function handleAddUser(){
		$user = array(
			'username' => I('username'),
			'nickname' => I('nickname'),
			'password' => I('password', '', 'md5'),
			'logintime' => time(),
			'loginip' => get_client_ip(),
			);

		$role = array();
		if($uid = M('user')->add($user)){
			foreach ($_POST['role_id'] as $v) {
				$role[] = array(
					'role_id' => $v,
					'user_id' => $uid
					);
			}

			M('role_user')->addAll($role);

			$this->success('添加成功', U(GROUP_NAME . "/GeneralManager/userList"));
		}else{
			$this->error('添加失败');
		}
	}

	public function handleDeleteUser(){
		$condition['id'] = I('id', -1, 'intval');
		if(M('user')->where($condition)->delete()){
			$this->success('删除成功', U(GROUP_NAME. '/GeneralManager/userList'));
		}else{
			$this->error('删除失败');
		}
	}

	/**
	 * 审核团队信息录入
	 * @return [type] [description]
	 */
	public function checkAddGroupInfo(){
		$condition['audittype'] = '0';
		$this->groups = M('tourgroup')->where($condition)->select();
		$this->display();
	}

	/**
	 * 审核团队信息录入详细页面
	 * @return [type] [description]
	 */
	public function checkAddGroupInfoDetail(){
		$this->target = M('tourgroup')->where(array('id' => I('id')))->find();
		$this->display();				
	}

	/**
	 * 审核团队信息修改
	 * @return [type] [description]
	 */
	public function checkModifyGroupInfo(){
		$condition['audittype'] = '1';
		$this->groups = M('tourgroup')->where($condition)->select();
		$this->display();
	}


	/**
	 * 审核团队信息修改详细页面
	 * @return [type] [description]
	 */
	public function checkModifyGroupInfoDetail(){
		$this->target = M('tourgroup')->where(array('id' => I('id')))->find();
		$this->display();
	}

	public function handleCheck(){
		$condition['id'] = I("id");
		$tourgroup = M("tourgroup");
		$log = $tourgroup->where($condition)->getField("log");

		$new_group;
		if(I("btn") == "success"){
			$new_group = array(
				'audittype' => '2',		//0表示添加的团队,1修改团队, 2已审核,3审核不通过
				'time' => time(),
				'log' => $log . date('y-m-d H:i:s',time()) . " 审核通过<br>",
				);
		}else{
			$new_group = array(
				'audittype' => '3',		//0表示添加的团队,1修改团队, 2已审核,3审核不通过
				'time' => time(),
				'log' => $log . date('y-m-d H:i:s',time()) . "审核未通过/n",
				);
		}

		
		if($tourgroup->where($condition)->save($new_group)){
			$this->success('操作成功', U(GROUP_NAME . "/GeneralManager/checkGroupInfo"));
		}else{
			$this->error('操作失败');
		}
	}

	/**
	 * 处理审核通过
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	private function handleCheckSuccess($id){
		$tourgroup = M("tourgroup");
		$group = $tourgroup->where(array('id' => $id))->find();
		$tourgroup->where(array('id' => $id))->delete();

		$new_group = array(
				'members' => $group->members,
				'shop' => $group->shop,
				'senddate' => $group->senddate,
				'recvdate' => $group->recvdate,
				'routetitle' => $group->routetitle,
				'routedays' => $group->routedays,
				'route' => $group->route,
				'offices' => $group->offices,
				'type' => $group->type,
				'remark' => $group->remark,
				'jidiao' => $group->jidiao,
				'guides' => $group->guides,
				'isshop' => $group->isshop,
			);

			if($M("tourgroup_audited")->add($new_group)){
				$this->success('操作成功', U(GROUP_NAME . "/GeneralManager/checkAddGroupInfo"));
			}else{
				$this->error('操作失败');
			}
	}

	/**
	 * 处理审核失败
	 * @return [type] [description]
	 */
	private function handleCheckFailed($id){
		$condition['id'] = $id;
		$tourgroup = M("tourgroup");

		if($tourgroup->where($condition)->delete()){
			$this->success('操作成功', U(GROUP_NAME . "/GeneralManager/checkAddGroupInfo"));
		}else{
			$this->error('操作失败');
		}	
	}


	/**
	 * 添加计调
	 */
	public function addJiDiao(){
		$this->display();
	}

	public function handleAddJiDiao(){
		$jidiao = array(
				'username' => I('name'),
				'phone' => I('phone'),
				'password' => I('name', '', 'md5'),
				'logintime' => time(),
				'loginip' => get_client_ip(),
			);

		$jidiao_role_id = M("role")->where(array('name' => '计调'))->getField('id');

		if($uid = M('user')->add($jidiao)){
			$role = array(
					'role_id' => $jidiao_role_id,
					'user_id' => $uid
					);

			M('role_user')->add($role);

			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
	}

	/**
	 * 添加办事处
	 */
	public function addOffice(){
		$this->display();
	}

	public function handleAddOffice(){
		$office["name"] = I("name");
		$office["phone"] = I("phone");

		if(M("office")->add($office)){
			$this->success("添加成功");
		}else{
			$this->error("添加失败");
		}
	}

	/**
	 * 查看团队详情
	 * @return [type] [description]
	 */
	public function detailGroupInfo(){
		$condition['id'] = I("id");
		$this->groupInfo = M("tourgroup")->where($condition)->find();
		$this->display();
	}

}


?>