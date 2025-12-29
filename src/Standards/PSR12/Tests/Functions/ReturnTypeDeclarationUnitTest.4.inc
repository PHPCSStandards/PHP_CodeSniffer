<?php

// Intentional parse error. There should be a colon between the function parameters and its return type.
function foo($obj = new DateTime(datetime: "now")) null {}
