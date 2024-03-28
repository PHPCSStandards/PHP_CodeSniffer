<?php

for ($i = 0; $i < 20; $i++) {
    for ($j = 0; $j < 5; $i += 2) {
        for ($k = 0; $k > 3; $i++) {
            
        }
    }
}

for ($i = 0; $i < 20; $i++) {
    for ($j = 0; $j < 5; $j += 2) {
        for ($k = 0; $k > 3; $k++) {
            
        }
    }
}

for ($i = 0; $i < 20; $i++) {
    for ($j = 0; $j < 5; $j += 2) {
        for ($k = 0; $k > 3; $j++) {
            
        }
    }
}

for (; $i < 10; $i++) {
    for ($j = 0;; $j++) {
        if ($j > 5) {
            break;
        }
        for (;; $k++) {
            if ($k > 5) {
                break;
            }
        }
    }
}

for (; $i < 10; $i++) {
    for ($j = 0;; $i++) {
        if ($j > 5) {
            break;
        }
        for (;; $i++) {
            if ($k > 5) {
                break;
            }
        }
    }
}

for ($i = 0; $i < 20; $i++) :
    for ($j = 0; $j < 5; $j += 2) :
    endfor;
endfor;

for ($i = 0; $i < 20; $i++) :
    for ($j = 0; $j < 5; $i += 2) :
    endfor;
endfor;

// Sniff bails early when there is no incrementor in the outer for loop.
for ($i = 0; $i < 10;) {
    ++$i;
    for ($j = 0; $j < 5; $i++) {}
}

for ($i = 1, $j = 0; $i <= 10; $i++, $j++) {
    for ($j = 0, $k = 0; $k < 5; $j++, $k++) {}
}

for ($i = 20; $i > 0; $i--) {
    for ($j = 5; $j > 0; $j -= 2) {
        for ($k = 3; $k > 0; $k--) {}
    }
}

for ($i = 20; $i > 0; $i--) {
    for ($j = 5; $j > 0; $i -= 2) {
        for ($k = 3; $k > 0; $i--) {}
    }
}
