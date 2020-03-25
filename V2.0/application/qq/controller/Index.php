<?php
namespace app\qq\controller;  
use think\Controller;  
class Index extends Controller  
{  
    //访问QQ登录页面  
    public function qqLogin(){  
        $oauth = new \qq_connect\Oauth();  
        $oauth->qq_login();  
    }  
    public function qqLoginview(){
        return view();
    }
    public function logout(){
        cookie('accesstoken', null);
        cookie('openid', null);
        cookie('nickname', null);
        cookie('icon', null);
        cookie('type', null);
        return json(["code"=>"400","info"=>"注销成功！即将刷新界面！"]);
    }
  
    //qq回调函数  
    public function index(){  
        //请求accesstoken  
        $oauth = new \qq_connect\Oauth();  
        $accesstoken = $oauth->qq_callback();  
       
        if($_GET["type"]){
        
           if($_GET["type"]==2){
            cookie('type', '2', 24*60*60); 
           }
           else{
            cookie('type', '1', 24*60*60);
           }
        }else{
             return false;
        }
        //获取open_id  
        $openid = $oauth->get_openid();  
  
        //设置有效时长(7天)  
        cookie('accesstoken', $accesstoken, 24*60*60);  
        cookie('openid', $openid, 24*60*60);  
  
        //根据accesstoken和open_id获取用户的基本信息  
        $qc = new \qq_connect\QC($accesstoken,$openid);  
        $userinfo = $qc->get_user_info();  
        cookie('nickname', $userinfo['nickname'], 24*60*60); 
        cookie('icon', $userinfo['figureurl_qq_1'], 24*60*60); 
        $this->redirect('http://www.jloongking.cn/tp50/public/qq/index/qqloginview?openid='.cookie('openid').'&nickname='.$userinfo['nickname'].'&icon='.$userinfo['figureurl_qq_1']);
    }  
  
  
  
} 
