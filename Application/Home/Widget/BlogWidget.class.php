<?php
namespace Home\Widget;
use Think\Controller;
class BlogWidget extends Controller{
	public function index(){
		$blog = '';
		$blog .= '<div class="hdt"><h3>热点推荐</h3><ul>';
		$d = $this->getBlog();
		foreach($d as $k=>$v){
			$blog .= '<li><a target="_blank" href="'.U('Blog/blogDetail','bid='.$v['blogid']).'">'.$v['title'].'</a></li>';
		}
		$blog .= '</ul></div>';
		echo $blog;
	}

	public function getBlog(){
		$blog = M('blog')->where(array('enable'=>1))->limit(8)->select();
		return $blog;
	}

}