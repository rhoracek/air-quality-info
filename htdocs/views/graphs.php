<?php include('partials/head.php'); ?>
<p></p>
<div class="row">
  <div class="col-md-8 offset-md-2 text-center">
    <div class="btn-group btn-group-sm graph-range" role="group" aria-label="<?php echo __('Range') ?>">
      <button type="button" class="btn btn-primary" data-range="day"><?php echo __('Day') ?></button>
      <button type="button" class="btn btn-secondary" data-range="week"><?php echo __('Week') ?></button>
      <button type="button" class="btn btn-secondary" data-range="month"><?php echo __('Month') ?></button>
      <button type="button" class="btn btn-secondary" data-range="year"><?php echo __('Year') ?></button>
    </div>
    <div class="btn-group btn-group-sm graph-avg-type" role="group" aria-label="<?php echo __('Moving average') ?>">
      <button type="button" class="btn btn-secondary" data-avg-type="0"><?php echo __('Instantaneous') ?></button>
      <button type="button" class="btn btn-primary" data-avg-type="1">1h</button>
      <button type="button" class="btn btn-secondary" data-avg-type="24">24h</button>
    </div>
  </div>
</div>
<?php
$graphs = array();
if (isset($device['value_mapping']['pm10']) || isset($device['value_mapping']['pm25'])) {
  $graphs['pm'] = __('PM');
}
if (isset($device['value_mapping']['temperature'])) {
  $graphs['temperature'] = __('Temperature');
}
if (isset($device['value_mapping']['humidity'])) {
  $graphs['humidity'] = __('Humidity');
}
if (isset($device['value_mapping']['pressure'])) {
  $graphs['pressure'] = __('Pressure');
}
$i = 0;
foreach($graphs as $type => $name):
?>
<?php if ($i % 2 == 0): ?>
<div class="row">
<?php endif ?>
  <div class="col-md-6 text-center">
    <div class="graph-container" data-range="day" data-type="<?php echo $type ?>" data-avg-type="1">
      <canvas class="graph"></canvas>
    </div>
  </div>
<?php if ($i++ % 2 == 1): ?>
</div>
<?php endif ?>
<?php endforeach; ?>
<?php include('partials/tail.php'); ?>