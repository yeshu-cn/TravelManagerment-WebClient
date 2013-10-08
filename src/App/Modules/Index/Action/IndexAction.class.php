<?php

	Class IndexAction extends Action{
		Public function index(){
			echo 'this is index';
		}


		//just for test
		Public function verify(){
			//框架自带的验证码
			import('ORG.Util.Image');
			Image::buildImageVerify();
		}

	}



?>