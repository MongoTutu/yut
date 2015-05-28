<?php
namespace Home\Widget;
use Think\Controller;
class TagsWidget extends Controller{
	public function index(){
		$tag = '';
		$tag .= '<div class="tags"><h3>猜你喜欢</h3><ul>';
		$d = $this->hotTag();
		foreach($d as $k=>$v){
			$tag .= '<li><a href="'.U('Index/tagFind','tid='.$v['tagid']).'">'.$v['tagname'].'</a></li>';
		}
		$tag .= '</ul></div>';					
		echo $tag;
	}

	public function hotTag(){
		$tag = M('tags')->limit(10)->select();
		return $tag;
    }

}