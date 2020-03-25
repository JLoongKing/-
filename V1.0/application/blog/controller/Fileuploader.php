<?php
namespace app\blog\controller;

class Fileuploader
{
    //上传文件函数
    public function up()
    {
      if(isset($_FILES['upfile'])){  
        $arr_ext = explode('.', $_FILES["upfile"]["name"]);  
        $path = "Uploads/".date('Ymd').'/';  
        if(!is_dir($path)){  
            mkdir($path,0777,true);  
        }  
        $file_path = $path.uniqid().'.'.$arr_ext[1];  
        //复制图片  
        if(move_uploaded_file($_FILES["upfile"]["tmp_name"], $file_path)){  
          return json(['code'=>400,"url"=>'/tp50/public/'.$file_path,"info"=>"up success"]);
        }else{  
          return json(['code'=>401,"info"=>"up fail"]);
        }  
    }  
    }

}