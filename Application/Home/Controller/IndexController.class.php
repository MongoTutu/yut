<?php
namespace Home\Controller;
use Common\Controller\CommonController;
class IndexController extends CommonController {

	public function index(){
		$this->nav = 1;
		$lb = M('fileinfo')->limit(5)->order('id asc')->select();
		$art = M('article')->limit(5)->order('id desc')->select();
		$this->lb = $lb;
		$this->art = $art;
		$this->display();
	}

	public function pic(){
		$this->nav = 2;
		$img = M('fileinfo')->order('id desc')->select();
		$this->img = $img;
		$this->display();
	}

	public function article(){
		$this->nav = 3;
		$art = M('article')->field('title,time,id')->select();
		$this->art = $art;
		$this->display();
	}

	public function articleDetail(){
		$id = $_GET['id'];
		$d = M('article')->where(array('id'=>$id))->find();
		$cmt = M('comment')->where(array('aid'=>$id))->select();
		$this->cmt = $cmt;
		$this->info = $d;
		$this->display('atccon');
	}

	public function talk(){
		$this->nav = 4;
		$d = M('talk')->order('id desc')->select();
		$this->talk = $d;
		$this->display();
	}

	public function vedio(){
		$this->nav = 5;
		$this->display();
	}

	public function log(){
		if($_SESSION['id']){
			$this->redirect('index');
		}
		$this->errorTip = $_GET['tip'];
		$this->display();
	}

	public function register(){
		if($_SESSION['id']){
			$this->redirect('index');
		}
		$this->errorTip = $_GET['tip'];
		$this->display();
	}

	public function registerPost(){
		$d = $_POST;
		if(!$d['username'] || !$d['pwd']){
			$tip = '信息不可为空';
		}
		if($d['pwd'] != $d['repwd']){
			$tip = '两次输入的密码不一致';
		}
		// 用户名重复，非法字符
		// 密码6-16位
		if($tip){
			$this->redirect('register?tip='.$tip);
			return false;
		}

		$dp['username'] = $d['username'];
		$dp['password'] = md5($d['pwd']);
		$dp['regtime'] = time();
		$dp['status'] = 1;
		$res = M('user')->data($dp)->add();
		if($res){
			cookie('username',$dp['username']);
			cookie('id',$res);
			$_SESSION['username'] = $dp['username'];
			$_SESSION['id'] = $res;
			$this->redirect('index');
		}
	}

	public function logPost(){
		$d = $_POST;
		$dp['username'] = $d['username'];
		$dp['password'] = md5($d['pwd']);
		$res = M('user')->where($dp)->find();
		if($res){
			cookie('username',$res['username']);
			cookie('id',$res['id']);
			$_SESSION['username'] = $res['username'];
			$_SESSION['id'] = $res['id'];
			$this->redirect('index');
		}else{
			$this->redirect('log?tip=用户名或密码错误');
		}
	}

	public function logout(){
		cookie('username',null);
		cookie('id',null);
		$_SESSION['username'] = null;
		$_SESSION['id'] = null;
		$this->redirect('log');
	}

	public function commentPost(){
		$d = $_POST;
		if(!$_SESSION['id']){
			$this->ajaxReturn(array('status'=>2));
		}
		$dp['aid'] = $d['aid'];
		$dp['comment'] = $d['comment'];
		$dp['uid'] = $_SESSION['id'];
		$dp['time'] = time();
		$res = M('comment')->data($dp)->add();
		if($res){
			$adc['username'] = getUsername($dp['uid']);
			$adc['comment'] = $dp['comment'];
			$adc['time'] = friendlyDate($dp['time']);
			$this->ajaxReturn($adc);
		}else{
			$this->ajaxReturn(array('status'=>'0'));
		}
	}

	public function addTalk(){
		$d = $_POST;
		if(!$_SESSION['id']){
			$this->ajaxReturn(array('status'=>2,'data'=>'你没有登录，就不要评论了'));
		}
		$dp['content'] = $d['content'];
		$dp['time'] = time();
		$dp['uid'] = $_SESSION['id'];
		$cc = M('talk')->data($dp)->add();
		if($cc){
			$cg['content'] = $dp['content'];
			$cg['time'] = friendlyDate($dp['time']);
			$cg['username'] = getUsername($dp['uid']);
			$this->ajaxReturn(array('status'=>1,'dt'=>$cg));
		}else{
			$this->ajaxReturn(array('status'=>2,'data'=>'Error!!'));
		}
	}




}
