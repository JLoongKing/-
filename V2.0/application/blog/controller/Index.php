<?php
namespace app\blog\controller;
use \think\Db;
use \think\Request;
class Index extends Base
{
   function index(){
       $pagenum= Request::instance()->get('pagenum');
       $typeid= Request::instance()->get('typeid');
       if($pagenum==null){
            $pagenum=1;
       } 
       $keyword="php,blog,个人博客,jloongking,开源博客系统";
        $title="jloongking博客首页";
        $description="jloongking的个人博客,代码公开的博客系统";
       if($typeid==null||$typeid=="all"){
           
            $banners=Db::table('t_banner')->select();
            $blogtype=Db::table('t_blogtype')->field('id,typeName')->select();
            $sign=Db::table('t_blogger')->field('sign')->select();
            $blogs=Db::table('t_blog')->order('id desc')->limit(5*($pagenum-1),5)->field('clickHit,id,typeId,title,summary,update_time')->select();
            $count=Db::table('t_blog')->count();
            $news=Db::table('t_blog')->order('id desc')->limit(0,4)->field('id,title')->select();
            $hots=Db::table('t_blog')->order('clickHit desc')->limit(0,4)->field('id,title')->select();
            return view('index',['banners'=>$banners,'count'=>$count,'sign'=>$sign,'blogtype'=>$blogtype,'blogs'=>$blogs,'news'=>$news,'hots'=>$hots,'pagenum'=>$pagenum,'typeid'=>'all','keyword'=>$keyword,'description'=>$description,'title'=> $title]);
        }
        else{
            $banners=Db::table('t_banner')->select();
            $blogtype=Db::table('t_blogtype')->field('id,typeName')->select();
            $blogtypename=Db::table('t_blogtype')->where('id',$typeid)->field('typeName')->select();
            $keyword=$keyword.$blogtypename[0]['typeName'];
            $title='jloongking博客类别'.$blogtypename[0]['typeName'];
            $description= $description.$blogtypename[0]['typeName'].'分类';
            $keyword=$keyword.$blogtypename[0]['typeName'];
            $sign=Db::table('t_blogger')->field('sign')->select();
            $blogs=Db::table('t_blog')->order('id desc')->limit(5*($pagenum-1),5)->where('typeId',$typeid)->field('clickHit,id,typeId,title,summary,update_time')->select();
            $count=Db::table('t_blog')->where('typeId',$typeid)->count();
            $news=Db::table('t_blog')->order('id desc')->limit(0,4)->field('id,title')->select();
            $hots=Db::table('t_blog')->order('clickHit desc')->limit(0,4)->field('id,title')->select();
            return view('index',['banners'=>$banners,'count'=>$count,'sign'=>$sign,'blogtype'=>$blogtype,'typeid'=>$typeid,'blogs'=>$blogs,'news'=>$news,'hots'=>$hots,'pagenum'=>$pagenum,'keyword'=>$keyword,'description'=>$description,'title'=> $title]);
        }
    }
    function blog(){
            $blogid= Request::instance()->get('blogid');
        
            $keyword="php,blog,个人博客,jloongking,开源博客系统";
            $title="jloongking博客首页";
            $description="jloongking的个人博客,代码公开的博客系统";
            $banners=Db::table('t_banner')->select();
            $blogtype=Db::table('t_blogtype')->field('id,typeName')->select();
            $sign=Db::table('t_blogger')->field('sign')->select();
            $blog=Db::table('t_blog')->where('id',$blogid)->field('clickHit,id,keyword,typeId,title,content,update_time,summary')->select();
            $count=Db::table('t_blog')->count();
            $news=Db::table('t_blog')->order('id desc')->limit(0,4)->field('id,title')->select();
            $hots=Db::table('t_blog')->order('clickHit desc')->limit(0,4)->field('id,title')->select();
            $keyword=$keyword.$blog[0]['keyword'];
            $title='jloongking博客：'.$blog[0]['title'];
            $description= $description.$blog[0]['summary'];
            return view('blog',['banners'=>$banners,'count'=>$count,'sign'=>$sign,'blogtype'=>$blogtype,'blog'=>$blog,'news'=>$news,'hots'=>$hots,'keyword'=>$keyword,'description'=>$description,'title'=> $title]);
       
     }
     function aboutme(){
            $keyword="php,blog,个人博客,jloongking,开源博客系统,jloongking个人简介";
            $title="jloongking博客首页,jloongking个人简介";
            $description="jloongking的个人博客,代码公开的博客系统,jloongking个人简介";
             $banners=Db::table('t_banner')->select();
             $blogtype=Db::table('t_blogtype')->field('id,typeName')->select();
             $sign=Db::table('t_blogger')->field('sign')->select();
             $profile=Db::table('t_blogger')->field('profile')->select();
             $news=Db::table('t_blog')->order('id desc')->limit(0,4)->field('id,title')->select();
             $hots=Db::table('t_blog')->order('clickHit desc')->limit(0,4)->field('id,title')->select();
             return view('aboutme',['banners'=>$banners,'sign'=>$sign,'news'=>$news,'hots'=>$hots,'profile'=> $profile,'keyword'=>$keyword,'description'=>$description,'title'=> $title]);

     }
}
