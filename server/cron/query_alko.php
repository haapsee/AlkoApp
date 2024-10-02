<?php
function getAlkoExcel($filename) {
    $output = null;
    $status = null;

    // THis might need a better solution
    exec(
        "curl 'https://www.alko.fi/INTERSHOP/static/WFS/Alko-OnlineShop-Site/-/Alko-OnlineShop/fi_FI/Alkon%20Hinnasto%20Tekstitiedostona/alkon-hinnasto-tekstitiedostona.xlsx' -H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:130.0) Gecko/20100101 Firefox/130.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/png,image/svg+xml,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' -H 'Accept-Encoding: gzip, deflate, br, zstd' -H 'Connection: keep-alive' -H 'Cookie: visid_incap_2611631=bNBrChDYRCGxO1oxG5d55j3P+2YAAAAAQUIPAAAAAADxQjlsuIglyyg1m94U3wU6; incap_ses_277_2611631=cqATRXR2eU5+th+IOxrYAyIh/GYAAAAANkBNxtMLz2yiULpy4Xd4Gw==; sid=uIJaHJXIY5RTHPMzd7w-H5fCdbSnuZZTEUOcKG5ULIbi9A==; pgid-Alko-OnlineShop-Site=ssRg63isRVBSRpIIYwMZ40rF0000Why92iLg; __Host-SecureSessionID-83d8cffb65ffa184c7fcb24c403da536=cf3687777b438ba400271d1b847a7f5fe7d6cfc969413dcaa908bc2e7ab09201; nlbi_2611631=bCjdRLwVX0iOIIABOs0cZQAAAAArGl6UCdjFH/H2z1PV6LDn; deviceType=might-be-mouse-device; global-message-closed=true' -H 'Upgrade-Insecure-Requests: 1' -H 'Sec-Fetch-Dest: document' -H 'Sec-Fetch-Mode: navigate' -H 'Sec-Fetch-Site: same-origin' -H 'Priority: u=0, i' -H 'TE: trailers' -o " . $filename,
        $output,
        $status
    );
    echo 'Alko query status: ' . $status . "\n";
}
?>