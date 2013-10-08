<?php
	
	/**
	 *	团队信息管理类
	 */
	class GroupManagerAction extends CommonAction{

		/**
		 *	显示添加团队信息页面
		 */
		public function showAddGroupInfo(){
			$this->display();
		}

		/**
		 *	显示管理自己的团队信息页面
		 */
		public function showSelfGroupInfos(){
			$jidiao = "管正坤";
			$dbTourGroup = M('tourgroup');
			$this->myGroups = $dbTourGroup->where(array('jidiao_name' => $jidiao))->select();
			$this->display();
		}

		/**
		 *	显示所有的团队信息页面
		 */
		public function showAllGroupInfos(){
			$this->allGruops = M('tourgroup')->select();
//			p($this->allGruops);
			$this->display();
		}
		
		/**
		 *	处理添加团队信息表单
		 */		
		public function addGroupInfoHandle(){
			p($_POST);
			$tourgroup = M("tourgroup");
			$group = array(
				'type' => I('type'),
				'number' => I('number'),
				'receive_date' => I('receive_date'),
				'send_date' => I('send_date'),
				'guides' => I('guides'),
				'line_title' => I('title'),
				'line_detail' => I('detail'),
				'jidiao_name' => I('jidiao'),
				'banshichu' => I('banshichu'),
				'beizhu' => I('beizhu'),
				'shop' => I('shop'),
				'day_number' => I('line_day_number'),
			);

			if($tourgroup->add($group)){
				$this->success('添加成功', U(GROUP_NAME . "/GroupManager/showAllGroupInfos"));
			}else{
				$this->error('添加失败');
			}
		}



		private function deleteGruopInfoHandle(){
			$dbTourGroup = M("tourgroup");
			$id = I('id');
			if($dbTourGroup->where(array("id" => $id))->delete()){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}

		}

		private function updateGroupInfoHandle(){
			$dbTourGroup = M("tourgroup");
			$id = I("id");

			$dbTourGroup->jidiao_name = I("jidiao");
			$dbTourGroup->where(array("id" => $id))->save();
		}


	}

?>