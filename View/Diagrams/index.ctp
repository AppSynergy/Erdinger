
<?php

// includes
$this->Html->css('/Erdinger/css/erdinger', null, array('inline' => false));
$this->Html->css('http://fonts.googleapis.com/css?family=Lato', array('inline' => false));
$this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js', array('inline' => false));
$this->Html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js', array('inline' => false));
$this->Html->script('Erdinger.jsPlumb/jquery.jsPlumb-1.3.16-all.js', array('inline' => false));

// vars
$endpoints = array();
$hasOneConnections = array();
$hasManyConnections = array();
$hABTMConnections = array();
foreach($data as $modelName => $modelInfo) {
    // endpoints are model names
    $endpoints[] = '"'.$modelName.'"';
    // connections are associations
    $hasMany = array_keys($modelInfo['assoc']['hasMany']);
    if(!empty($hasMany)) {
        foreach($hasMany as $hm) {
            $hasManyConnections[] = '["'.$modelName.'","'.$hm.'"]';
        }
    }
    $hABTM = array_keys($modelInfo['assoc']['hasAndBelongsToMany']);
    if(!empty($hABTM)) {
        foreach($hABTM as $ha) {
            $hABTMConnections[] = '["'.$modelName.'","'.$ha.'"]';
        }
    }
    $hasOne = array_keys($modelInfo['assoc']['hasOne']);
    if(!empty($hasOne)) {
        foreach($hasOne as $ho) {
            $hasOneConnections[] = '["'.$modelName.'","'.$ho.'"]';
        }
    }
}
echo $this->Html->scriptblock('
    var erdEndPoints = ['.implode(", ", $endpoints).'];
    var erdHasManyConnections = ['.implode(", ", $hasManyConnections).'];
    var erdHABTMConnections = ['.implode(", ", $hABTMConnections).'];
    var erdHasOneConnections = ['.implode(", ", $hasOneConnections).'];
', array('inline' => false));

// custom
$this->Html->script('Erdinger.erdinger.js', array('inline' => false));




// PAGE CONTENT
?>

<h1>Erdinger - ERD Diagrams for cakePHP</h1>
<p>Drag and drop to make this diagram look prettier, then save a screen grab for your records.</p>

<div id="erdingerKey">
    <strong>Key:</strong>
    <ul>
        <li class="hasOne">hasOne</li>
        <li class="hasMany">hasMany</li>
        <li class="hasHABTM">hasAndBelongsToMany</li>
</div>

<div id="erdingerCanvas">
<?php
foreach($data as $modelName => $modelInfo) {
    echo '<div class="erdingerClass" id="erd'.$modelName.'">';
    echo "<h3>".$modelName."</h3>";
    echo "<p><strong> | ";
    foreach($modelInfo['schema'] as $fieldName => $fieldAttrs) {
        echo $fieldName."  |  ";
    }
    echo "</strong><br /><em>";
    foreach($modelInfo['assoc'] as $assocType => $assocInfo) {
        foreach($assocInfo as $assocModel => $assocAttrs) {
            echo $assocType." --> ".$assocModel."<br />";
        }
    }
    echo '</em></p></div>';
}
?>
</div>