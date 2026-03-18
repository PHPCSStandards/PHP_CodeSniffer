<?php

$i = 10;
--$i;
-- $i;
-- /*comment*/ $i;
++$i;
++ 
   $i;
++/*comment*/$i;

$i--;
$i        --;
$i /*comment*/ --;
$i++;
$i ++;
$i /*comment*/ ++;

// Handle properties and array access too.
$i['key']++;
$i['key'] ++;
$i['key']['id']++;
$i['key']['id'] ++;

$obj->prop++;
$obj->prop ++;
$obj?->prop ++;

$obj->obj->prop++;
$obj->obj->prop ++;
$obj?->obj->prop ++;

$obj->prop['key']++;
$obj->prop['key'] ++;

--ClassName::$prop;
-- ClassName::$prop;

getObject()->count
++;
getObject()->count++;
++ getObject()->count;
++getObject()->count;

++
\Fully\Qualified()->count;
++\Fully\Qualified()->count;
-- Partially\Qualified()->count;
--Partially\Qualified()->count;
++    namespace\relative()->count;
++namespace\relative()->count;

++\ClassName::$prop;
++ \ClassName::$prop;
++Relative\ClassName::$prop;
++    Relative\ClassName::$prop;
--namespace\Relative\ClassName::$prop;
-- /*comment*/ namespace\Relative\ClassName::$prop;
