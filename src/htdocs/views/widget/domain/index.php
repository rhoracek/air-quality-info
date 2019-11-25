
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("partials/ga.php") ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>aqi.eco</title>
    <link rel="stylesheet" href="/public/css/vendor.min.css"/>
    <link rel="stylesheet" href="/public/css/themes/default.min.css"/>
    <link rel="stylesheet" href="/public/css/font_aqi.css"/>
    <style>
      h5 {
        font-size: 1.4rem;
      }

      small {
        font-size: 95%;
      }

      .container a {
        text-decoration: none;
        border: none;
      }

      .list-group-item:first-child {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }

      .list-group-item:last-child {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
      }

      .list-group-item {
        margin-bottom: -10px;
      }

      .air-quality-null,
      .air-quality-0,
      .air-quality-1,
      .air-quality-2,
      .air-quality-3,
      .air-quality-4 {
        border: none;
      }

      .air-quality-null {
        background-color: gray;
      }

      .air-quality-0 {
        background-color: #80bc66;
      }

      .air-quality-1 {
        background-color: #bccf40;
      }

      .air-quality-2 {
        background-color: #e9c100;
      }

      .air-quality-3 {
        background-color: #eb9200;
      }

      .air-quality-4 {
        background-color: #8f0014;
      }

      .dropshadow {
        text-shadow: 0 0 3px #000;
      }

      .white {
        color: #fff;
      }

      .green {
        color: #1bb152;
      }

      .orange {
        color: #ffc00f;
      }

      .red {
        color: #e6150d;
      }

      .strip {
        background-color: #fff;
        display: block;
        border-radius: 5px;
        padding: 5px;
        font-weight: normal;
        color: #000;
        text-align: left;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        -moz-align-items: center;
        align-items: center;
      }

      .strip-recommended {
        display: block;
        color: #000;
        text-align: left;
        margin-left: 8px;
        line-height: 17px;
      }

      .strip-recommended-description {
        color: #000;
        font-size: 14px;
        text-align: left;
      }
    </style>
</head>

<body>
    <div class="container">
      <a href="<?php echo $siteUrl ?>" target="_parent">
        <ul class="row list-group">
            <li class="list-group-item text-center air-quality-<?php echo $level === null ? 'null' : $level; ?>">
                <h5 class="mb-0 dropshadow white">
                    <?php echo $title ?>
                </h5>
                <small class="dropshadow white"><?php echo __('Current air quality') ?></small>
            </li>

            <?php if ($level !== null): ?>
              <?php include(sprintf('%s/level-%d.php', 'pl'/*$currentLocale->getCurrentLang()*/, $level)); ?>
            <?php else: ?>
              <li class="list-group-item text-center air-quality-null">
                <h4 class="dropshadow white"><?php echo __('There are no data') ?></h4>
              </li>
            <?php endif ?>

            <li class="list-group-item text-center air-quality-<?php echo $level === null ? 'null' : $level; ?>">
              <small class="dropshadow white"><?php echo __('Click to see more details.') ?></small>
            </li>
        </ul>
      </a>

    </div>
    <footer class="text-muted text-center">
        <small>
            <?php if (isset($domainTemplate['widget_footer'])): ?>
            <?php echo $domainTemplate['widget_footer'] ?><br/>
            <?php endif ?>
            <?php echo __('Powered by ') ?><a href="https://aqi.eco">aqi.eco</a>.
        </small>
    </footer>
    <script>
var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod === "attachEvent" ? "onload" : "load";
eventer(messageEvent, function(e) {
  parent.postMessage({
    'aqi-widget': <?php echo $widgetId ?>,
    'frameHeight': document.body.scrollHeight
  }, '*');
});
    </script>
</body>
</html>
