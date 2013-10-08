<?php

	/**
	 *	导游的信息管理类
	 *
	 */
	class GuideManagerAction extends CommonAction{

		public function addGuide(){
			$this->display();
		}

		public function dispatchGuide(){
			$this->tourGroups = M('tourgroup')->select();
			$this->display();
		}

		public function showGuideList(){
			$this->guides = M('guide')->select();
			$this->display();
		}

		public function addGuideHandle(){
			$dbGuide = M("guide");
			$guide = array(
			'name' => I('name'),
			'phone' => I('phone'),
			);

			if($dbGuide->add($guide)){
				$this->success('添加成功', U(GROUP_NAME . "/GuideManager/showGuideList"));
			}else{
				$this->error('添加失败');
			}
		}

		public function deleteGuide(){
			$id = I("id");
			$dbGuide = M("guide");
			if($dbGuide->where(array("id" => $id))->delete()){
				$this->success('删除成功', U(GROUP_NAME . "/GuideManager/showGuideList"));
			}else{
				$this->error('删除失败');
			}
		}

	}
?>