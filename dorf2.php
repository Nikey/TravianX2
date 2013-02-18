<?php

#################################################################################
##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                 ##
## --------------------------------------------------------------------------- ##
##  Filename       dorf2.php                                                   ##
##  Developed by:  Dzoki                                                       ##
##  License:       TravianX Project                                            ##
##  Copyright:     TravianX (c) 2010-2011. All rights reserved.                ##
##                                                                             ##
#################################################################################
include("GameEngine/Village.php");
$start = $generator->pageLoadTimeStart();
if(isset($_GET['newdid'])) {
	$_SESSION['wid'] = $_GET['newdid'];
	header("Location: ".$_SERVER['PHP_SELF']);
}else{
$building->procBuild($_GET);
}
if(isset($_GET['master']) && isset($_GET['id']) && isset($_GET['time']) && $session->gold >= 1 && $session->goldclub) {
if($session->access!=BANNED){
$level = $database->getResourceLevel($village->wid);
$database->addBuilding($village->wid, $_GET['id'], $_GET['master'], 1, $_GET['time'], 1, $level['f'.$_GET['id']] + 1 + count($database->getBuildingByField($village->wid,$_GET['id'])));
header("Location: ".$_SERVER['PHP_SELF']);
}else{
header("Location: banned.php");
}
}
//Debug Units
  function debugUnits() {
  $debug_startwert = 4000000;
  //debug truppen in kaserne/stall/werkstatt
  $sql = "SELECT * FROM ".TB_PREFIX."training";
  $result = mysql_query($sql)or die(mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
  $training_units_id[] = $row['id'];
  $training_units_check[] = $row['amt'];
  }
  $count_train_units = count($training_units_id);
  $i = 0;
  while ($i < $count_train_units) {
  if ($training_units_check[$i] > $debug_startwert) {
  mysql_query("DELETE FROM ".TB_PREFIX."training WHERE id = ".$training_units_id[$i]);
  }
  $i++;
  }
  //debug truppen unterstuetzungen
  $i = 1;
  $sql_erw = "";
  while ($i <= 50) {
  if ($i != 50) {
  $sql_erw += "u".$i." > ".$debug_startwert." OR ";
  }
  else {
  $sql_erw += "u".$i." > ".$debug_startwert."";
  }
  $i++;
  }
  $sql = "SELECT * FROM ".TB_PREFIX."enforcement WHERE ".$sql_erw."";
  $result = mysql_query($sql)or die(mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
  $enforcement_units_check[] = $row['id'];
  }
  $count_enforcement_units = count($enforcement_units_check);
  $i = 0;
  while ($i < $count_enforcement_units) {
  if ($enforcement_units_check[$i] > $debug_startwert) {
  mysql_query("DELETE FROM ".TB_PREFIX."enforcement WHERE id = ".$enforcement_units_check[$i]);
  }
  $i++;
  }
  //debug truppen im dorf
  $i = 1;
  $sql_erw = "";
  while ($i <= 50) {
  if ($i != 50) {
  $sql_erw += "u".$i." > ".$debug_startwert." OR ";
  }
  else {
  $sql_erw += "u".$i." > ".$debug_startwert."";
  }
  $i++;
  }
  $sql = "SELECT * FROM ".TB_PREFIX."units WHERE ".$sql_erw."";
  $result = mysql_query($sql)or die(mysql_error());
  while ($row = mysql_fetch_assoc($result)) {
  $units_check[] = $row['id'];
  }
  $count_units = count($units_check);
  $i = 0;
  while ($i < $count_units) {
  if ($units_check[$i] > $debug_startwert) {
  mysql_query("DELETE FROM ".TB_PREFIX."units WHERE id = ".$units_check[$i]);
  }
  $i++;
  }
 }
 debugUnits();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title><?php echo SERVER_NAME ?></title>
	<link REL="shortcut icon" HREF="favicon.ico"/>
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<script src="mt-full.js?0faaa" type="text/javascript"></script>
	<script src="unx.js?0faaa" type="text/javascript"></script>
	<script src="new.js?0faaa" type="text/javascript"></script>
	<link href="<?php echo GP_LOCATE; ?>lang/en/lang.css?f4b7c" rel="stylesheet" type="text/css" />
	<link href="<?php echo GP_LOCATE; ?>lang/en/compact.css?f4b7c" rel="stylesheet" type="text/css" />
	<?php
	if($session->gpack == null || GP_ENABLE == false) {
	echo "
	<link href='".GP_LOCATE."travian.css?e21d2' rel='stylesheet' type='text/css' />
	<link href='".GP_LOCATE."lang/en/lang.css?e21d2' rel='stylesheet' type='text/css' />";
	} else {
	echo "
	<link href='".$session->gpack."travian.css?e21d2' rel='stylesheet' type='text/css' />
	<link href='".$session->gpack."lang/en/lang.css?e21d2' rel='stylesheet' type='text/css' />";
	}
	?>
	<script type="text/javascript">

		window.addEvent('domready', start);
	</script>
</head>


<body class="v35 ie ie8">
<div class="wrapper">
<img style="filter:chroma();" src="img/x.gif" id="msfilter" alt="" />
<div id="dynamic_header">
	</div>
<?php include("Templates/header.tpl"); ?>
<div id="mid">
<?php include("Templates/menu.tpl"); ?>
		<div id="content"  class="village2">
<h1><?php echo $village->vname; if($village->loyalty!='100'){ if($village->loyalty>'33'){ $color="green"; }else{ $color="red"; } ?><div id="loyality"><span style="color:<?php echo $color; ?>;font-size:xx-small;" size><?php echo LOYALTY; ?> <?php echo floor($village->loyalty); ?>%</span></div><?php } ?></h1>
<?php include("Templates/dorf2.tpl");
if($building->NewBuilding) {
	include("Templates/Building.tpl");
}
?>
</div>
</br></br></br></br><div id="side_info">
<?php
include("Templates/multivillage.tpl");
include("Templates/quest.tpl");
include("Templates/news.tpl");
include("Templates/links.tpl");
?>
</div>
<div class="clear"></div>
</div>
<div class="footer-stopper"></div>
<div class="clear"></div>
<?php
include("Templates/footer.tpl");
include("Templates/res.tpl");
?>
<div id="stime">
<div id="ltime">
<div id="ltimeWrap">
<?php echo CALCULATED_IN;?> <b><?php
echo round(($generator->pageLoadTimeEnd()-$start)*1000);
?></b> ms
<br /><?php echo SEVER_TIME;?> <span id="tp1" class="b"><?php echo date('H:i:s'); ?></span>
</div>
	</div>
</div>
<div id="ce"></div>
</body>
</html>
