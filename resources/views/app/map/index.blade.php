<iframe frameborder="0" style="overflow:hidden;height:100%;width:100%" width="100%" height="100%" src="https://www.openstreetmap.org/export/embed.html?bbox=<?= ((float)$_GET['long'] - 0.005) . "," . ((float)$_GET['lat'] - 0.005) . "," . ((float)$_GET['long'] + 0.005) . "," . ((float)$_GET['lat'] + 0.005) ?>&layer=mapnik&marker=<?= $_GET['lat'] . "," . $_GET['long'] ?>" style=" border: 1px solid black"></iframe>