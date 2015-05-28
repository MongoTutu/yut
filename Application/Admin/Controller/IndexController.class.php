<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

	public function _initialize(){
		$id = $_SESSION['id'];
		if(!$id){
			$this->redirect('Home/Index/log');
		}

		$sta = M('user')->where(array('id'=>$id))->getfield('status');
		if($sta==1){
			$this->redirect('Home/Index/log');
		}
	}

	public function index(){
		$this->display();
	}

	public function articlePost(){
		$d = $_POST;
		$dp['title'] = $d['title'];
		$dp['content'] = $d['content'];
		$dp['uid'] = $_SESSION['id'];
		$dp['time'] = time();
		$dp['status'] = 1;
		$res = M('article')->data($dp)->add();
		if($res){
			$this->success('发布成功了！');
		}else{
			$this->error('Error!!!!');
		}
	}

	public function fileupload(){
		import("ORG.Net.UploadFile");
		$upload = new \UploadFile();
		$upload->saveRule = md5(time().$_FILES['Filedata']['name']);
		$upload->savePath = './Public/Uploads/';
		$upload->allowExts = array('gif','jpg','jpeg','bmp','png','swf');

		/*thumb file*/

		$upload->thumb = true;
		$upload->thumbMaxWidth = '220';
		$upload->thumbMaxHeight = '1080';
		$upload->thumbPrefix = 's_';
		$upload->thumbRemoveOrigin = false;

		$info = $upload->upload();
		if(!$info) {
			$this->error($upload->getErrorMsg());
		}else{
			$info = $upload->getUploadFileInfo();
			unset($info[0]['key']);
			$fileid = M('fileinfo')->data($info[0])->add();
		}
	}




}
