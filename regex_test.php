<?php
$text = 'Nama: ${nama_lengkap} Agama: ${agama} Tujuan: ${tujuan} Pekerjaan: ${pekerjan}';
preg_match_all('/(?:\$\{?|\{|\[)\s*([a-zA-Z0-9_]+)\s*(?:\}|\}|\])/', $text, $matches);
print_r($matches[1]);
