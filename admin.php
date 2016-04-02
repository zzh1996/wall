<?php
  require("pw.php");
  if (!isset($_SERVER['PHP_AUTH_USER'])||!isset($_SERVER['PHP_AUTH_PW'])||$_SERVER['PHP_AUTH_USER']!="zzh"||$_SERVER['PHP_AUTH_PW']!=$PW){
    header('WWW-Authenticate: Basic realm="admin"');
    header('HTTP/1.0 401 Unauthorized');
    exit();
  }
  $db=new mysqli("localhost","root",$PW,"wall");
  mysqli_query($db,"set NAMES UTF8");
  mysqli_query($db,"set character set 'utf8'");
  if(isset($_GET['id'])){
    $id=$_GET['id'];
    if(!isset($_GET['del']))
      $s=$db->prepare("UPDATE posts set visible=1-visible where id=?");
    else
      $s=$db->prepare("UPDATE posts set visible=2 where id=?");
    $s->bind_param('s',$id);
    $s->execute();
    echo '<meta charset="utf-8"><script>alert("OK");</script><meta http-equiv="refresh" content="0;url=/admin.php">';
    exit();
  }
?>

<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">

    <title>USTC表白墙管理</title>

    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-theme.min.css" rel="stylesheet"/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container col-sm-offset-3 col-sm-6">
      <div class="header clearfix">
        <h3>USTC表白墙管理</h3>
      </div>

      <hr>

<?php
  $s=$db->prepare("SELECT id,content,t,visible FROM posts WHERE visible<2 ORDER BY t DESC");
  $s->execute();
  $s->store_result();
  $s->bind_result($id,$content,$t,$v);
  while($s->fetch()){
    echo "<hr>";
    echo "<div class='text-muted'>ID=$id $t</div>";
    $content=htmlspecialchars($content);
    echo "<div>$content</div>";
    $p=($v?"删除":"通过");
    echo "<a href='admin.php?id=$id'>$p</a>&nbsp;&nbsp;";
    echo "<a href='admin.php?id=$id&del=1'>彻底删除</a>";
  }
?>

      <hr>

      <div>
        <p>
          <span class="text-muted">Copyright &copy; <a href="https://sqrt-1.me">负一的平方根</a> 2015</span>
        </p>
      </div>

    </div>

  </body>
  <!-- Bootstrap core JavaScript -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</html>
