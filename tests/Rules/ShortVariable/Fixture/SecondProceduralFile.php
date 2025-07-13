<?php

// Second procedural file - this $i should be a violation
// but might be skipped if state persists and it thinks line 4 was already processed  
$i = 'second file'; // Should be violation (might be missing if state persists)
