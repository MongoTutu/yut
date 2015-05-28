<?php
namespace Home\Widget;
use Think\Controller;
class QrcodeWidget extends Controller{
	public function index(){
		$qr = '';
		$qr .= '<div id="Qrcode">';
		$qr .= '<img src="'.__ROOT__.'/Public/img/qrcode.jpg" >';
		$qr .= '</div>';
		echo $qr;
	}

}