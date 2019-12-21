<?php 
    function pre($arr){
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    // 读取目录函数
    function showDir($dirname){
        $dir = opendir($dirname);
        while(($file = readdir($dir)) != false){
            if($file != '.'){
                $arr[] = $file;
            }
        }
        closedir($dir);
        return $arr;
    }

    // 查看文件的信息
    function getFileInfo($dirname){
        $arr = [];
        $arr['basename'] = basename($dirname);
        $arr['size'] = getFileSize($dirname);
        $arr['type'] = getFileType($dirname);
        $arr['ctime'] = date('Y/m/d h:i:s',filectime($dirname));
        $arr['mtime'] = date('Y/m/d h:i:s',filemtime($dirname));
        return $arr;
    }

    //获取文件类型
    function getFileType($file){
        switch(filetype($file)){
            case 'dir':
                return '目录';
            case 'char':
                return '字符设备';
            case 'file':
                return '文件';
            case 'link':
                return '链接';
            case 'block':
                return '块设备';
            default :
                return '未知设备';
        }
    }

    // 获取文件大小
    function getFileSize($dirname){
        $fileSize = filesize($dirname);
        // $size = preg_match('/(\d+\.\d{3})/',$fileSize / pow(2,10),$point);
        if($fileSize > pow(2,40)){
            $size = preg_match('/(\d+\.\d{3})/',$fileSize / pow(2,40),$point);
            return $size = $point[0].'TB';
        }elseif($fileSize > pow(2,30)){
            $size = preg_match('/(\d+\.\d{3})/',$fileSize / pow(2,30),$point);
            return $size = $point[0].'GB';
        }elseif($fileSize >= pow(2,20)){
            $size = preg_match('/(\d+\.\d{3})/',$fileSize / pow(2,20),$point);
            return $size = $point[0].'MB';
        }elseif($fileSize >= pow(2,10)){
            $size = preg_match('/(\d+\.\d{3})/',$fileSize / pow(2,10),$point);
            return $size = $point[0].'KB';
        }else{
            return $size = $fileSize.'Btye';
        }
    }

    // 新建文件
    function creatFile($filename){
        if(!file_exists($filename)){
            if(touch($filename)){
                echo "<script>alert('文件创建成功！')</script>";
            };
        }else{
            echo "<script>alert('该文件已存在！')</script>";
        }
    }   

    // 删除文件
    function delFile($filePath){
        if(file_exists($filePath)){
            if(is_file($filePath)){
                $res = unlink($filePath);
                if($res){
                    return '文件删除成功！';
                }
            }else{
                $dir = opendir($filePath);

                while(($file = readdir($dir)) != false){
                    if($file != '.' && $file != '..'){
                        $next_path = $filePath.'/'.$file;
                        delFile($next_path);
                    }                    
                }
                closedir($dir);
                return rmdir($filePath) ? "删除{$filePath}成功！" : "删除{$filePath}失败！";
            }
        }else{
            echo '删除失败，该文件不存在！';
        }
    }
