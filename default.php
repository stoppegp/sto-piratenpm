<?php

$mailadressen = explode("\n", file_get_contents("std/mailadressen.tpl"));

$std_ansprechpartner1 = file_get_contents("std/ansprechpartner1.tpl");

$std_ansprechpartner2 = file_get_contents("std/ansprechpartner2.tpl");

$std_ansprechpartner3 = file_get_contents("std/ansprechpartner3.tpl");

$std_anschreiben = file_get_contents("std/anschreiben.tpl");

$std_footer = file_get_contents("std/footer.tpl");

$std_treffen = file_get_contents("std/treffen.tpl");

$std_anschrift = file_get_contents("std/anschrift.tpl");

$std_pdf_header = file_get_contents("std/pdf_header.tpl");

$std_from = file_get_contents("std/from.tpl");
$std_fromname = file_get_contents("std/fromname.tpl");

$std_smtphost = file_get_contents("std/smtphost.tpl");
$std_smtpuser = file_get_contents("std/smtpuser.tpl");
$std_smtppass = file_get_contents("std/smtppass.tpl");

$std_trenner = "-----------------------------------------------------------------";


?>