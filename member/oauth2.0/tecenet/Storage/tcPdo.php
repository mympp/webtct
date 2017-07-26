<?php

class tcPdo extends OAuth2\Storage\Pdo{
	
	//重写checkPassword方法
	//验证规则，用户提交进行了一次md5加密的密码串，将获得的密码串再次md5加密后和salt拼接，然后再进行一次md5加密，所得字符串与记录数据进行匹对
	public function checkPassword($user,$password){
		return $user['password'] == md5(md5($password).$user['passsalt']);
	}
}
?>