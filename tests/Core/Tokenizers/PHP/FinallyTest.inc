<?php

class FinallyAsMethod {
    /* testFinallyUsedAsClassConstantName */
    const FINALLY = 'foo';

    /* testFinallyUsedAsMethodName */
    public function finally() {
        // Do something.

        /* testFinallyUsedAsPropertyName */
        $this->finally = 'foo';
    }
}
