<?php
namespace Home\Widget;
use Think\Controller;
class AskWidget extends Controller{
	public function index(){
		$ask = '<div class="hdt"><h3>知识精华</h3><ul>';
		$d = $this->getAsk();
		foreach($d as $k=>$v){
			$ask .= '<li><a href="'.U('Ask/askDetail','aid='.$v['askid']).'">'.$v['title'].'</a></li>';
		}
		$ask .= '</ul></div>';
		echo $ask;
	}

	public function getAsk(){
		$askJH = M('ask')->where(array('answer'=>array('gt','2')))->select();
		return $askJH;
	}

}