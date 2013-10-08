<?php

class RbacAction extends CommonAction{
	//用户列表
	public function index(){
		$this->user = D('UserRelation')->field('password', true)->relation(true)->select();
		$this->display();
	}

	//角色列表
	public function role(){
		$this->role = M('role')->select();
		$this->display();
	}
	//节点列表
	public function node(){
		$field = array('id', 'name', 'title', 'pid');
		$node = M('node')->field($field)->order('sort')->select();
		$this->node = node_merge($node);
		$this->display();
	}

	//添加用户
	public function addUser(){
		$this->role = M('role')->select();
		$this->display();
	}

	//添加用户表单处理
	public function addUserHandle(){
		$user = array(
			'username' => I('username'),
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

			$this->success('添加成功', U(GROUP_NAME . "/Rbac/index"));
		}else{
			$this->error('添加失败');
		}
	}


	//添加角色
	public function addRole(){
		$this->display();
	}

	//添加角色表单操作
	public function addRoleHandle(){
		if(M('role')->add($_POST)){
			$this->success('添加成功', U(GROUP_NAME . '/Rbac/role'));
		}else{
			$this->error('添加失败');
		}
	}
	//添加节点
	public function addNode(){
		$this->pid = I('pid', 0, 'intval');
		$this->level = I('level', 1, 'intval');

		switch($this->level){
			case 1 :
				$this->type = "应用";
				break;
			case 2:
				$this->type = "控制器";
				break;
			case 3:
				$this->type = "动作方法";
				break;
		}
		$this->display();
	}

	public function addNodeHandle(){
//		if(!IS_POST)
		/*
			这里有个安全行问题，还有数据库操作依赖html表单名
		*/
		if(M('node')->add($_POST)){
			$this->success("添加成功", U(GROUP_NAME . "/Rbac/node"));
		}else{
			$this->error("添加失败");
		}
	}

	/**
	 * 删除节点
	 * @return [type] [description]
	 */
	public function deleteNode(){
		$condition['id'] = I('id');

		if(M('node')->where($condition)->delete()) {
			$this->success("删除成功", U(GROUP_NAME . "/Rbac/node"));
		}else{
			$this->error("删除失败");
		}
	}

	/**
	 * 修改节点信息
	 * @return [type] [description]
	 */
	public function updateNode(){
		echo "待开发！";
	}

	public function access(){
		$rid = I('rid', 0, 'intval');

		$field = array('id', 'name', 'title', 'pid');
		$node = M('node')->order('sort')->field($field)->select();

		//原有权限
		$access = M('access')->where(array('role_id' => $rid))->getField('node_id', true);
		$this->node = node_merge($node, $access);

		$this->rid = $rid;
		$this->display();
	}

	public function setAccess(){

		$rid = I('rid', 0, 'intval');
		$db = M('access');

		//delete old access
		$db->where(array('role_id' => $rid))->delete();

		$data = array();
		foreach ($_POST['access'] as $v) {
			$tmp = explode('_', $v);
			$data[] = array(
				'role_id' => $rid,
				'node_id' => $tmp[0],
				'level' => $tmp[1],
				);
		}

		if($db->addAll($data)){
			$this->success('修改成功', U(GROUP_NAME . '/Rbac/role'));
		}else{
			$this->error('修改失败');
		}
	}

}

?>