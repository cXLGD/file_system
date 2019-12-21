<?php 
    include './functions.php';
    // pre(pathinfo($_SERVER['SCRIPT_FILENAME'])['dirname']);

    if(!empty($_GET['path'])){
        $dirname = $_GET['path'];
    }else{
        $dirname = pathinfo($_SERVER['SCRIPT_FILENAME'])['dirname'];
    }

    pre($dirname);
    // 创建文件
    $creatName = $_POST['new_file_name'];
    if(!empty($_POST['sub_file']) && isset($creatName)){
        $new_path = $dirname.'/'.$creatName;
        creatFile($new_path);
        echo "<script>setTimeout(function(){
            window.location.href={$dirname};
        },3000)</script>";
    }

    // 删除文件
    if($_GET['del']){
        $msg = delFile($_GET['del']);
        // pre($_GET['del']);pre(dirname($_GET['del']));die;
        $del_now_path = dirname($_GET['del']);
        echo "<script>alert('{$msg}');window.location.href='?path={$del_now_path}'</script>";
    }


    // pre($dirname);
    $infos = showDir($dirname);

    // pre($infos);

    // 获取文件信息
    foreach($infos as $items){
        $info_list[] = getFileInfo($dirname.'/'.$items);
    }
    // pre($info_list);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="../bootstrap/css/bootstrap.css"/>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
        <h2 class="text-center text-primary">简易文件系统</h2>
        </div>
        <div class="row">
        <form class="form-inline" method='post'>
            <div class="form-group">
                <label class="sr-only" for="exampleInputPassword3">Password</label>
                <input type="text" class="form-control" name="new_file_name" id="exampleInputText" placeholder="新文件名">
            </div>
            
            <button type="submit" class="btn btn-default" name="sub_file" value="sub_file">创建文件</button>
            </form>
        </div>
        <div class="row">
            <table class="table table-striped">
            <tr align="center">
                <td>文件名称</td>
                <td>文件大小</td>
                <td>文件类型</td>
                <td>创建时间</td>
                <td>修改时间</td>
                <td>操作</td>
            </tr>
            <?php foreach($info_list as $val){
                $basename = $val['basename']; 
                if($basename == '..'){
                    $link = substr($dirname, 0, strrpos($dirname, '/'));
                    // $befor = preg_match('/(.*?)\.$/',$dirname,$arr); 
                    // $link = $arr[0];
                    // pre($link);
                }else{
                    // echo $basename;
                    $link = $dirname.'/'.$basename;
                }
                
                ?>
                <tr align="center">
                    <td><?php if($val['type'] == '目录'){
                        if($basename == '..'){
                            echo "<a href='?path=$link' class='text-info'><strong>返回上层目录</strong></a>";
                        }else{
                            echo "<a href='?path=$link' class='text-info'><strong>{$basename}</strong></a>";
                        }
                        
                    }else{
                        echo "<span class='text-success'>$basename</span>";
                    }
                     ?></td>

                    <td><?php if($val['type'] != '目录'){
                            echo $val['size'];
                     }
                     ?></td>

                     <td><?php  echo $val['type'];?></td>

                     <td><?php echo $val['ctime'] ?></td>
                     <td><?php echo $val['mtime'] ?></td>
                     <td><?php if($basename != '..' && $basename != '.'){echo "<a href='?del={$link}' class='text-danger'>删除</a>";} ?></td>
                </tr>
            <?php }?>
            </table>
        </div>
    </div>


    <script src="../js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>