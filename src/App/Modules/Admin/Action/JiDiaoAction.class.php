<?php

	class JiDiaoAction extends CommonAction{
		public function addGroup(){
			/**
			$users = D('UserGuideRelation')->field('password', true)->relation(true)->select();
			
			$guides = array();
			foreach ($users as $user) {
				foreach($user["role"] as $role){
					if($role["name"] == "导游"){
						$guides[] = $user;
					}
				}
			}
			**/
			$this->offices = D("office")->field("name")->select();
			$this->jidiao = session("username");
			$this->guides = $guides;
			$this->display();
		}

		/**
		 *	管理计调自己的团队信息
		 */
		public function manageGroup(){
			$username = session("username");
			$this->groups = M('tourgroup')->where(array('jidiao' => $username))->select();
			$this->display();
		}

		/**
		 *	查询所有的团队信息,只显示已审核的团队信息
		 */
		public function queryGroup(){
			$condition["audittype"] = 2;
			$this->groups = M('tourgroup')->where($condition)->select();
			$this->display();
		}

		/**
		 * 查看待审核的团队信息
		 * @return [type] [description]
		 */
		public function queryUnCheckGroup(){
			$username = session("username");
			$this->groups = M('tourgroup')->where(array('jidiao' => $username))->select();
			$this->display();
		}


		/**
		 * 添加团队信息到审核列表中
		 */
		public function addGroupHandle(){
			$tourgroup = M("tourgroup");
			$group = array(
				'members' => I('members'),
				'shop' => I('shop'),
				'senddate' => I('senddate'),
				'recvdate' => I('recvdate'),
				'routetitle' => I('routetitle'),
				'routedays' => I('routedays'),
				'route' => I('route'),
				'offices' => I('offices'),
				'type' => I('type'),
				'remark' => I('remark'),
				'jidiao' => session("username"),
				//'guides' => implode(' ', I('guides')),
				'isshop' => I('isshop'),
				'audittype' => '0',		//0表示添加的团队,1修改团队, 2已审核
				'time' => time(),
				'log' => date('y-m-d H:i:s',time()) . "录入团队信息<br>",
			);
			
			if($tourgroup->add($group)){
				$this->success('添加成功', U(GROUP_NAME . "/JiDiao/manageGroup"));
			}else{
				$this->error('添加失败');
			}
		}

		public function updateGroupDetail(){
			$this->group = M('tourgroup')->where(array('id' => I('id')))->find();
			$this->display();
		}

		/**
		 * 添加团队修改的信息到审核类表中
		 * @return [type] [description]
		 */
		public function updateGroupHandle(){
			$condition['id'] = I('id');
			$tourgroup = M("tourgroup");
			$log = $tourgroup->where($condition)->getField("log");

			//获取团队信息，update
			$group = array(
				'members' => I('members'),
				'shop' => I('shop'),
				'senddate' => I('senddate'),
				'recvdate' => I('recvdate'),
				'routetitle' => I('routetitle'),
				'routedays' => I('routedays'),
				'route' => I('route'),
				'offices' => I('offices'),
				'type' => I('type'),
				'remark' => I('remark'),
				'isshop' => I('isshop'),
				'audittype' => '1',		//0表示添加的团队,1修改团队, 2已审核
				'time' => time(),
				'log' => $log . date('y-m-d H:i:s',time()) . "修改团队信息<br>",
			);

			
			if($tourgroup->where($condition)->save($group)){
				$this->success('修改成功', U(GROUP_NAME . "/JiDiao/manageGroup"));
			}else{
				$this->error('修改失败');
			}
		}


		public function deleteGroupHandle(){
			$condition['id'] = I('id', -1, 'intval');
			if(M('tourgroup')->where($condition)->delete()){
    			$this->success('删除成功', U(GROUP_NAME. '/JiDiao/manageGroup'));
    		}else{
    			$this->error('删除失败');
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