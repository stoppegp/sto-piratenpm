<?php
include('functions.php');
include('default.php');
session_start();
if ($_POST['reset'] == "true") {
    if (is_dir("out/".session_id())) {
        delTree("out/".session_id());
    }
    session_destroy();
    session_start();
     session_regenerate_id(true);
     $_SESSION['start'] = "true";
     $_SESSION['ansprechpartner1'] = $std_ansprechpartner1;
     $_SESSION['ansprechpartner2'] = $std_ansprechpartner2;
     $_SESSION['ansprechpartner3'] = $std_ansprechpartner3;
     $_SESSION['anschreiben'] = $std_anschreiben;
     $_SESSION['footer'] = $std_footer;
     $_SESSION['step'] = 1;
}
if (isset($_POST['step'])) {
    $_SESSION['step'] = $_POST['step'];
} else {
    $_SESSION['step'] = "0";
}

if ($_SESSION['start'] != "true") {
    $_SESSION['step'] = "0";
}
if (isset($_POST['cancel'])) {
    $_SESSION['step'] = "1";
}

if ($_SESSION['step'] == "send") {

        /* E-Mail erstellen */
        
        $goon = true;
        for ($a=0;$a<=2;$a++) {
            if ($_POST['check'][$a] != "yes") { $goon = false; break; }
        }
        
        if (($goon == true) || ($_POST['test'] == "yes")) {
        
            require('phpmailer/class.phpmailer.php');
          
            $mail = new PHPMailer();
            $mail->From = $std_from;
            $mail->FromName = $std_fromname;
            
            if ($_POST['test'] != "yes") {
                if (is_array($_SESSION['email']) & (count($_SESSION['email']) > 0)) {
                    foreach ($_SESSION['email'] as $key => $val) {
                        $mail->AddBCC($key);
                    }
                }
                if (is_array($_SESSION['emailplus']) & (count($_SESSION['emailplus']) > 0)) {
                    foreach ($_SESSION['emailplus'] as $key => $val) {
                        $mail->AddBCC($val);
                    }
                }
            } else {
                $mail->AddBCC($_POST['testmail']);
            }
            
            $mail->Subject = "Pressemitteilung: ".$_SESSION['titel'];
            $mail->Body = $_SESSION['mailtext'];

            $mail->AddAttachment('out/'.session_id().'/PM-Piraten.pdf','piraten-pm.pdf');
            $mail->AddAttachment('out/'.session_id().'/PM-Piraten.txt','piraten-pm.txt');
            
            if (is_array($_SESSION['anhang']) && (count($_SESSION['anhang']) > 0)) {
                foreach ($_SESSION['anhang'] as $key => $val) {
                    $mail->AddAttachment('out/'.session_id().'/anhang/'.$val,$val);
                }
            }
            
            /* E-Mail senden */
             if(!$mail->Send())
              {
                 //$mail->Send() liefert FALSE zurück: Es ist ein Fehler aufgetreten
                 $sendmsg = "Die Email konnte nicht gesendet werden";
                 $sendmsg .= "Fehler: " . $mail->ErrorInfo;
              }
              else
              {
                 //$mail->Send() liefert TRUE zurück: Die Email ist unterwegs
                 $sendmsg = "Die Email wurde versandt.";
              }
              
              if ($_POST['test'] == "yes") {
                $_SESSION['step'] = "1";
              }
              
        } else {
            $_SESSION['step'] = "1";
            $sendmsg = "Du hast nich alle Prüffragen abgehakt.";
        }
}

if ($_SESSION['step'] === "do_edit_pm") {
    $_SESSION['text'] = $_POST['text'];
    $_SESSION['titel'] = $_POST['titel'];
    $_SESSION['datum'] = $_POST['datum'];
    $_SESSION['pdf'] = "0";
    $_SESSION['txt'] = "0";
    $_SESSION['step'] = "1";
}
if ($_SESSION['step'] === "do_edit_ap") {
    $_SESSION['ansprechpartner1'] = $_POST['ansprechpartner1'];
    $_SESSION['ansprechpartner2'] = $_POST['ansprechpartner2'];
    $_SESSION['ansprechpartner3'] = $_POST['ansprechpartner3'];
    
    if ($_POST['ap1std'] == "yes") {
        $txt = fopen("std/ansprechpartner1.tpl", "w");
        fwrite($txt, $_SESSION['ansprechpartner1']);
        fclose($txt);
    }
    if ($_POST['ap2std'] == "yes") {
        $txt = fopen("std/ansprechpartner2.tpl", "w");
        fwrite($txt, $_SESSION['ansprechpartner2']);
        fclose($txt);
    }
    if ($_POST['ap3std'] == "yes") {
        $txt = fopen("std/ansprechpartner3.tpl", "w");
        fwrite($txt, $_SESSION['ansprechpartner3']);
        fclose($txt);
    }
    
    $_SESSION['pdf'] = "0";
    $_SESSION['step'] = "1";
}
if ($_SESSION['step'] === "do_edit_texte") {
    $_SESSION['anschreiben'] = $_POST['anschreiben'];
    $_SESSION['footer'] = $_POST['footer'];
    
    if ($_POST['anschreibenstd'] == "yes") {
        $txt = fopen("std/anschreiben.tpl", "w");
        fwrite($txt, $_SESSION['anschreiben']);
        fclose($txt);
    }
    if ($_POST['footerstd'] == "yes") {
        $txt = fopen("std/footer.tpl", "w");
        fwrite($txt, $_SESSION['footer']);
        fclose($txt);
    }
    
    $_SESSION['step'] = "1";
}
if ($_SESSION['step'] === "do_edit_mail") {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['emailplus'] = array();
    if (is_array(explode("\n", $_POST['emailplus']))) {
        foreach (explode("\n", $_POST['emailplus']) as $key => $val) {
            if (trim($val) != "") {
                $_SESSION['emailplus'][] = trim($val);
            }
        }
    }
    $_SESSION['step'] = "1";
}
if ($_SESSION['step'] === "do_edit_anhang_add") {
    if (isset($_FILES['addanhang']['tmp_name'])) {
        if (!is_dir("out/".session_id())) {
            mkdir("out/".session_id());
        }
        if (!is_dir("out/".session_id()."/anhang")) {
            mkdir("out/".session_id()."/anhang");
        }
        $dateiname = $_FILES['addanhang']['name'];
        $counter = 0;
        $dateiname0 = $dateiname;
        while (file_exists("out/".session_id()."/anhang/".$dateiname0)) {
            $dateiname0 = (++$counter).$dateiname;
        }
        if(move_uploaded_file($_FILES['addanhang']['tmp_name'], "out/".session_id()."/anhang/".$dateiname0)) {
            $_SESSION['anhang'][] = $dateiname0;
            sort($_SESSION['anhang']);
        }
    }
    $_SESSION['step'] = "1";
}
if ($_SESSION['step'] === "do_edit_anhang_del") {
    if (is_array($_POST['delanhang']) && (count($_POST['delanhang']) > 0)) {
        foreach ($_POST['delanhang'] as $key => $val) {
            if ($val == 1) {
                unlink("out/".session_id()."/anhang/".$_SESSION['anhang'][$key]);
                unset($_SESSION['anhang'][$key]);
            }
        }
    }
    if (is_array($_SESSION['anhang'])) {
        sort($_SESSION['anhang']);
    }
    $_SESSION['step'] = "1";
}
if ($_SESSION['step'] === "do_edit_pdf") {
    if (!is_dir("out/".session_id())) {
        mkdir("out/".session_id());
    }
    include("pdf.php");
    $_SESSION['pdf'] = "1";
    $_SESSION['step'] = "1";
}
if ($_SESSION['step'] === "do_edit_txt") {
    if (!is_dir("out/".session_id())) {
        mkdir("out/".session_id());
    }
    
    $txt = fopen("out/".session_id()."/PM-Piraten.txt", "w");
    fwrite($txt, $std_pdf_header."\r\n\r\n".$_SESSION['titel']."\r\n\r\n".$_SESSION['text']);
    fclose($txt);
        
    $_SESSION['txt'] = "1";
    $_SESSION['step'] = "1";
}

if ($_SESSION['step'] === "1") {
    if (($_SESSION['titel'] != "") && ($_SESSION['text'] != "") && ($_SESSION['datum'] != "")) {
        $ok_pm = true;
    } else {
        $ok_pm = false;
    }
    if (($_SESSION['ansprechpartner1'] != "") || ($_SESSION['ansprechpartner2'] != "") || ($_SESSION['ansprechpartner3'] != "")) {
        $ok_ap = true;
    } else {
        $ok_ap = false;
    }
    if (($_SESSION['anschreiben'] != "")) {
        $ok_texte = true;
    } else {
        $ok_texte = false;
    }
    if ((is_array($_SESSION['email']) && (count($_SESSION['email']) > 0)) || (is_array($_SESSION['emailplus']) && (count($_SESSION['emailplus']) > 0))) {
        $ok_mail = true;
    } else {
        $ok_mail = false;
    }
    if (($_SESSION['pdf'] == "1")) {
        $ok_pdf = true;
    } else {
        $ok_pdf = false;
    }
    if (($_SESSION['txt'] == "1")) {
        $ok_txt = true;
    } else {
        $ok_txt = false;
    }
    if (is_array($_SESSION['anhang']) && (count($_SESSION['anhang']) > 0)) {
        $ok_anhang = true;
    } else {
        $ok_anhang = false;
    }
    $_SESSION['mailtext'] = $_SESSION['anschreiben']."\n\n".$std_trenner."\n\n".$_SESSION['titel']."\n\n".$_SESSION['text']."\n\n".$std_trenner."\n\n";
    if ($_SESSION['ansprechpartner1'] || $_SESSION['ansprechpartner2'] || $_SESSION['ansprechpartner3']) {
        $_SESSION['mailtext'] .= "Ansprechpartner:\n\n";
    }
    if ($_SESSION['ansprechpartner1']) {
        $_SESSION['mailtext'] .= $_SESSION['ansprechpartner1']."\n\n";
    }
    if ($_SESSION['ansprechpartner2']) {
        $_SESSION['mailtext'] .= $_SESSION['ansprechpartner2']."\n\n";
    }
    if ($_SESSION['ansprechpartner3']) {
        $_SESSION['mailtext'] .= $_SESSION['ansprechpartner3']."\n\n";
    }
    $_SESSION['mailtext'] .= $std_trenner."\n\n";
    $_SESSION['mailtext'] .= $_SESSION['footer'];
        
}
include('header.tpl');

if ($_SESSION['step'] === "0") {
    include('step0.tpl');
}
if ($_SESSION['step'] === "1") {
    include('step1.tpl');
}
if ($_SESSION['step'] === "2") {
    include('step2.tpl');
}
if ($_SESSION['step'] === "edit_pm") {
    include('step_edit_pm.tpl');
}
if ($_SESSION['step'] === "edit_ap") {
    include('step_edit_ap.tpl');
}
if ($_SESSION['step'] === "edit_texte") {
    include('step_edit_texte.tpl');
}
if ($_SESSION['step'] === "edit_mail") {
    include('step_edit_mail.tpl');
}
if ($_SESSION['step'] === "edit_anhang_add") {
    include('step_edit_anhang_add.tpl');
}
if ($_SESSION['step'] === "edit_anhang_del") {
    include('step_edit_anhang_del.tpl');
}
if ($_SESSION['step'] === "send") {
    include('step_send.tpl');
}
include('footer.tpl');
?>
