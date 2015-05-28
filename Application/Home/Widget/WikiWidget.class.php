<?php
namespace Home\Widget;
use Think\Controller;
class WikiWidget extends Controller{
	public function index(){
		$wiki = '';
		$wiki .= '<div class="hdt"><h3>热门词条</h3><ul>';
		$d = $this->getWiki();
		foreach($d as $k=>$v){
			$wiki .= '<li><a target="_blank" href="'.U('Wiki/wikiDetail','wid='.$v['wikiid']).'">'.$v['title'].'</a></li>';
		}
		$wiki .= '</ul></div>';
		echo $wiki;
	}

	public function getWiki(){
		$wiki = M('wiki')->where(array('enable'=>1))->limit(8)->select();
		return $wiki;
	}

}