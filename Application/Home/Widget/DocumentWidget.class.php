<?php
namespace Home\Widget;
use Think\Controller;
class DocumentWidget extends Controller{
	public function index(){
		$doc = '';
		$doc .= '<div class="hdt"><h3>行业动态</h3><ul>';
		$d = $this->getDoc();
		foreach($d as $k=>$v){
			$doc .= '<li><a target="_blank" href="'.U('Document/docDetail','did='.$v['documentid']).'">'.$v['title'].'</a></li>';
		}
		$doc .= '</ul><a class="toKnowMore" href="'.U('Document/document').'">了解更多</a></div>';
		echo $doc;
	}

	public function getDoc(){
		$hotDoc = M('document')->limit(8)->select();
		return $hotDoc;
	}

}