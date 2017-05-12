<?php
/* Include all the classes */
include("pChart/class/pDraw.class.php");
include("pChart/class/pImage.class.php");
include("pChart/class/pData.class.php");

/* Create your dataset object */
$myData = new pData();
/* Add data in your dataset */
$myData->addPoints(array(VOID,3,4,3,5));

$myPicture = new pImage(700,230,$myData); // width, height, dataset
$myPicture->setGraphArea(60,40,670,190); // x,y,width,height
$myPicture->setFontProperties(array("FontName"=>"pChart/fonts/verdana.ttf","FontSize"=>11));

$myPicture->drawScale();
$myPicture->drawSplineChart();

$myPicture->Stroke();

?>