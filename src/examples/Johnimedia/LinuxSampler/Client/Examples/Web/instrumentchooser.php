<?php
require __DIR__.'/../../../../../../../vendor/autoload.php';

$instrumentFiles = [
  [
    'name' => 'TaijiguyGigaTron',
    'path' => '/home/pi/linuxsampler/TaijiguyGigaTron_switched.gig'
  ],
  [
    'name' => 'Famicom Soundfont',
    'path' => '/home/pi/linuxsampler/Famicom.sf2'
  ]
];

$channel = 0;

$sampler= new \Johnimedia\LinuxSampler\Client\LinuxSampler('192.168.178.47');
$sampler->connect();

function getInstrumentsFromFile($file) {
  global $sampler;
  $instruments = [];
  foreach ($sampler->listFileInstruments($file) as $instrumentId) {
    $instruments[$instrumentId] = $sampler->getFileInstrumentInfo($file, $instrumentId);
  }
  return $instruments;
}

$targetFileId = isset($_GET['fileId']) ? $_GET['fileId'] : null;
$targetInstrumentId = isset($_GET['instrumentId']) ? $_GET['instrumentId'] : null;

if ($targetFileId != null && $targetInstrumentId != null) {

  $instrumentInfo = $sampler->getFileInstrumentInfo($instrumentFiles[$targetFileId]['path'], $targetInstrumentId);
  $sampler->loadEngine($instrumentInfo->format_family, $channel);
  $sampler->loadInstrument($instrumentFiles[$targetFileId]['path'], $targetInstrumentId, $channel, true);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Instrument Chooser</title>
  <style type="text/css">
    body {
      margin: 0px;
      font-size: 19px;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      background-color: #333;
    }
    ul {
      list-style: none;
      margin: 0px;
      padding: 0px;
    }
    li a, li span {
      float: left;
      padding: 8px 10px;
      width: 100%;
      overflow: hidden;
      box-sizing: border-box;
      clear: both;
    }
    li a {
      color: #EEE;
      text-decoration: none;
    }
    li a:hover {
      background-color: #CCC;
      color: #000;
    }
    li span {
      background-color: #FF2AFF;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <ul>
    <?php foreach ($instrumentFiles as $instrumentFileId => $file) { ?>
      <li>
        <span><?php echo $file['name']; ?></span>
        <ul>
          <?php foreach (getInstrumentsFromFile($file['path']) as $instrumentId => $instrument) { ?>
            <li><a href="?fileId=<?php echo $instrumentFileId; ?>&instrumentId=<?php echo $instrumentId; ?>"><?php echo $instrument->name; ?></a></li>
          <?php } ?>
        </ul>
      </li>
    <?php } ?>
  </ul>
</body>
</html>