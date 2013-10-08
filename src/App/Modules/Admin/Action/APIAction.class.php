<?php
class APIAction extends APIBaseAction{

	/**
	 * 登录接口
	 */
	public function login(){
		$db = M('user');
		$user = $db->where(array('username' => I('username')))->find();

		if(!$user || $user['password'] != I('password', '', 'md5')){
			//登录失败
			$result = array (	
				'result'=> 1
				);
		}
		else
		{
			//更新最后一次登录时间与IP
			$data = array(
				'id' => $user['id'],
				'logintime' => time(),
				'loginip' => get_client_ip(),
				);
			$db->save($data);

			$session_id = session_id();

			$result = array (	
				'result'=> 0,
				'session_id'=> $session_id,
				'rolename' => "导游部经理",
				'phone' => "12341234001",
				'nickname' => "路人甲",
				'account' => session("username"),
				);

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
		}

		echo json_encode($result);
	}

	/**
	 *	退出登录
	 */
	public function logout(){
		$this->securityCheck();

		session_unset();
		session_destroy();
	}

	/**
	 *	获取导游列表
	 */
	public function getGuideList(){
		$this->securityCheck();

		//获取user中所有用户和用户角色信息
		$this->users = D('UserGuideRelation')->field('password', true)->relation(true)->select();
		//过滤出角色为导游的用户
		$guides = array();
		foreach($this->users as $user){
			foreach ($user['role'] as $role) {
				if($role['name'] == "导游"){
					$guide = array(
							'id' => $user['id'],
							'name' => urlencode($user['username']),
							'phone' => urlencode($user['phone']),
							'nickname' => urlencode($user['nickname']),
						);
					$guides[] = $guide;
					break;
				}
			}
		}
		echo urldecode(json_encode($guides));
	}


	/**
	 *	每次查询20条数据
	 */
	public function getTourGroupList(){
		$this->securityCheck();

		//获取参数
		$pageIndex = I("pageIndex");

		$groups = array();
		//在已审核的数据库中查找数据
		//select top 20* from (select Top 120* from orders order by orderid )a order by orderid desc
		
		//默认一页显示20条数据
		$datas = M("tourgroup")->order("id desc")->page($pageIndex, 20)->select();
//		$datas = M("tourgroup_audited")->order("id desc")->limit(0, 2)->select();

		foreach($datas as $item){
			$group = array(
				'id' => $item['id'],
				'members' => urlencode($item['members']),
				'shop' => $item['shop'],
				'senddate' => urlencode($item['senddate']),
				'recvdate' => urlencode($item['recvdate']),
				'routetitle' => urlencode($item['routetitle']),
				'routedays' => urlencode($item['routedays']),
				'route' => urlencode($item['route']),
				'offices' => urlencode($item['offices']),
				'type' => urlencode($item['type']),
				'remark' => urlencode($item['remark']),
				'jidiao' => urlencode($item['jidiao']),
				'guides' => urlencode($item['guides']),
				'isshop' => $item['isshop'],
			);

			$groups[] = $group;
		}

		echo urldecode(json_encode($groups));
	}


	/**
	 *
	 */
	public function dispatchGuide(){
		$this->securityCheck();

		$data['guides'] = I('guides');
		$condition['id'] = I('id');
		if(M('tourgroup')->where($condition)->save($data)){
			$this->onDispatchGuideSuccess();
		}else{
			$this->onDispatchGuideFailed();
		}

	}

	/**
	 * 获取用户个人信息
	 * @return [type] [description]
	 */
	public function getUserInfo(){	
		$this->securityCheck();

		$result = array (	
				'rolename' => urlencode("导游部经理"),
				'phone' => urlencode("12341234001"),
				'nickname' => urlencode("路人甲"),
				'account' => urlencode(session("username")),
				);
		echo urldecode(json_encode($result));
	}


	private function onDispatchGuideSuccess(){
		$result = array('result' => 0);
		echo json_encode($result);
	}

	private function onDispatchGuideFailed(){
		$result = array('result' => 1);
		echo json_encode($result);
	}

	

	/**
	 * 验证登录状态、是否有权限操作
	 * @return [type] [description]
	 */
	private function securityCheck(){
		//验证是否登录 todo
		if(!isset($_SESSION[C('USER_AUTH_KEY')])){
			//没有登录，返回未登录错误 
			$this->errorUnLogin();
			die;
		}

		//检查权限
		$noAuth = in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE'))) || in_array(ACTION_NAME, explode(',', C('NOT_AUTH_ACTION')));
		if(C('USER_AUTH_ON') && !$noAuth){
			//开启的了验证而且不是忽略验证的方法或控制器
			import("ORG.Util.RBAC");
			if(!RBAC::AccessDecision(GROUP_NAME)){
				//没有权限，返回没有权限错误
				$this->errorNoAccess();
				die;
			}else{
				return true;
			}
		}else{
			//不用验证权限就直接返回真了
			return true;
		}
	}

	private function errorUnLogin(){
		$error = array('error' => 'no login');
		echo json_encode($error);
	}

	private function errorNoAccess(){
		$error = array('error' => 'no access');
		echo json_encode($error);
	}

}


?>