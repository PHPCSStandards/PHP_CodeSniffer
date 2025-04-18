<?php

goto spacingOkay;
echo 'Foo';

spacingOkay:
echo 'Bar';

goto OneSpace;
echo 'Foo';

OneSpace :
echo 'Bar';

goto MultiSpace;
echo 'Foo';

MultiSpace     :
echo 'Bar';

goto NewLinesAndIndent;
echo 'Foo';

NewLinesAndIndent



      :
echo 'Bar';

goto TooMuchSpacePlusComment;
echo 'Foo';

TooMuchSpacePlusComment  /*comment*/  :
echo 'Bar';
