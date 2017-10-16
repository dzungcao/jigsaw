<?php
$command = 'magick gamedir/6yy0vx2m/1469096910_vbr5aelg.jpg -crop 225x225+365+96\! -background none -flatten +repage images/lib/toprightbottomleft1.png -alpha Off  -compose CopyOpacity -composite -crop 225x225+0+0 +repage gamedir/6yy0vx2m/54.png';

exec($command);