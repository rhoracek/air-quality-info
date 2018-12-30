<!DOCTYPE html>
<html lang="en">
  <head>
<?php if (isset($ga_id)): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_id; ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?php echo $ga_id; ?>');
    </script>
<?php endif; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta http-equiv="refresh" content="180" >
    <link rel="apple-touch-icon" href="img/dragon_white_background.png">
    <link rel="icon" type="image/png" href="img/dragon.png">

    <title>Jakość powietrza</title>

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-8 offset-md-2">
        <nav class="navbar navbar-expand-md navbar-light bg-light">
          <a href="index.php" class="navbar-left"><img src="img/dragon.png"/></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Nawigacja">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <?php foreach(array('index.php' => 'Strona główna', 'graph_all.php' => 'Wykresy') as $page => $name): ?>
              <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER["SCRIPT_FILENAME"]) == $page) ? 'active' : ''; ?>" href="<?php echo $page; ?>"><?php echo $name; ?></a>
              </li>
            <?php endforeach ?>
            </ul>
          </div>
        </nav>
      </div>
    </div>