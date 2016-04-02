<?php
  require("pw.php");
  $db=new mysqli("localhost","root",$PW,"wall");
  mysqli_query($db,"set NAMES UTF8");
  mysqli_query($db,"set character set 'utf8'");
  if(isset($_POST["content"])){
    $content=$_POST["content"];
    $s=$db->prepare("INSERT INTO posts (content,t,visible) VALUES (?,?,0)");
    $s->bind_param('ss',$content,date('Y-m-d H:i:s',time()));
    $s->execute();
    echo '<meta charset="utf-8"><script>alert("发表成功！管理员审核通过后即可展示在首页。");</script><meta http-equiv="refresh" content="0;url=/">';
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

    <title>USTC表白墙</title>

    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-theme.min.css" rel="stylesheet"/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .contentbg{
      background-image: linear-gradient(to bottom,pink 0,lightpink 100%);
    }
    </style>
  </head>

  <body>
    <div class="container">

      <nav class="navbar navbar-default" role="navigation">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" 
               data-target="#navbar-collapse">
               <span class="sr-only">切换导航</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">USTC表白墙</a>
         </div>
         <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/submit.php">我要表白</a></li>
            <li><a href="/search.php">搜索</a></li>
            <li><a href="/about.php">关于</a></li>
          </ul>
         </div>
      </nav>

      <!--<div class="header clearfix">
        <h3>USTC表白墙</h3>
      </div>-->

      <hr>

      <form class="form-horizontal" method="post">

        <div class="form-group">
          <div class="col-sm-12">
            <textarea class="form-control" name="content" id="content" placeholder="说点什么吧" rows="5"></textarea>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-2">
            <button id="submit" type="submit" name="button" class="btn btn-default">发表</button>
          </div>
        </div>

      </form>

<?php
  $s=$db->prepare("SELECT content,t FROM posts WHERE visible=1 ORDER BY t DESC LIMIT 0,50");
  $s->execute();
  $s->store_result();
  $s->bind_result($content,$t);
  while($s->fetch()){
    echo "<div class='col-md-3'>";
    echo "<div class='text-muted'>$t</div>";
    $content=htmlspecialchars($content);
    echo "<div class='well contentbg'>$content</div>";
    echo "</div>";
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
