<?php
if ($sendmsg) {
    ?>
    <div class="part0"><?=$sendmsg;?></div>
    <?
}
?>
<div class="part0">
<table border="1">

    <tr>
        <td>Pressemitteilung</td>
        <td><div class="<?php echo ($ok_pm == true) ? "ok" : "nok"; ?>">&nbsp;</div></td>
        <td><form action="index.php" method="post"><input type="hidden" name="step" value="edit_pm" /><input type="submit" value="Bearbeiten" /></form></td>
    </tr>
  
    <tr>
        <td>Ansprechpartner</td>
        <td><div class="<?php echo ($ok_ap == true) ? "ok" : "nok"; ?>">&nbsp;</div></td>
        <td><form action="index.php" method="post"><input type="hidden" name="step" value="edit_ap" /><input type="submit" value="Bearbeiten" /></form></td>
    </tr>  
    
    <tr>
        <td>Mail-Texte</td>
        <td><div class="<?php echo ($ok_texte == true) ? "ok" : "nok"; ?>">&nbsp;</div></td>
        <td><form action="index.php" method="post"><input type="hidden" name="step" value="edit_texte" /><input type="submit" value="Bearbeiten" /></form></td>
    </tr> 

    <tr>
        <td>Mail-Adressen</td>
        <td><div class="<?php echo ($ok_mail == true) ? "ok" : "nok"; ?>">&nbsp;</div></td>
        <td><form action="index.php" method="post"><input type="hidden" name="step" value="edit_mail" /><input type="submit" value="Bearbeiten" /></form></td>
    </tr>  
    
    <tr>
        <td>PDF</td>
        <td><div class="<?php echo ($ok_pdf == true) ? "ok" : "nok"; ?>">&nbsp;</div></td>
        <td><form action="index.php" method="post"><input type="hidden" name="step" value="do_edit_pdf" /><input type="submit" value="Neu generieren" /></form></td>
    </tr> 
    <tr>
        <td>TXT</td>
        <td><div class="<?php echo ($ok_txt == true) ? "ok" : "nok"; ?>">&nbsp;</div></td>
        <td><form action="index.php" method="post"><input type="hidden" name="step" value="do_edit_txt" /><input type="submit" value="Neu generieren" /></form></td>
    </tr> 
    <tr>
        <td>Anhänge</td>
        <td><div class="<?php echo ($ok_anhang == true) ? "ok" : ""; ?>">&nbsp;</div></td>
        <td><form action="index.php" method="post"><input type="hidden" name="step" value="edit_anhang_add" /><input type="submit" value="Hinzufügen" /></form> <form action="index.php" method="post"><input type="hidden" name="step" value="edit_anhang_del" /><input type="submit" value="Entfernen" /></form></td>
    </tr> 

</table>
</div>


<div class="part0">
<h3>Vorschau</h3>
<div class="pre">Betreff: <?php
if (trim($_SESSION['betreff']) != "") {
    echo $_SESSION['betreff'];
} else {
    echo "Pressemitteilung: ".$_SESSION['titel'];
}

?>


<?php echo htmlspecialchars($_SESSION['mailtext'], ENT_COMPAT | ENT_HTML401, "ISO8859-15"); ?>
</div>

<h3>Anhänge</h3>
<ul>
<li><a target="_blank" href="out/<?=session_id();?>/PM-Piraten.pdf">PM-Piraten.pdf</a></li>
<li><a target="_blank" href="out/<?=session_id();?>/PM-Piraten.txt">PM-Piraten.txt</a></li>
<?php   
    if (is_array($_SESSION['anhang']) && (count($_SESSION['anhang']) > 0)) {
        foreach ($_SESSION['anhang'] as $key => $val) {
            echo "<li><a target=\"_blank\" href=\"out/".session_id()."/anhang/".$val."\">".$val."</a></li>";
        }
    }
?>
</ul>
</div>
<div class="part0">
<h3>Testmail</h3>
<form action="index.php" method="post">
<input type="hidden" name="test" value="yes" />
<input type="hidden" name="step" value="send" />
<input type="text" name="testmail" value="<?=$std_from;?>" /> <input  type="submit" value="Testmail senden" />
</form>
</div>
<div class="part0">
<h3>E-Mail verschicken</h3>
Die Mail wird an folgende Adressen (im BCC) verschickt:
<ul>
    <?php
        if ((is_array($_SESSION['email']) && (count($_SESSION['email']) > 0)) || (is_array($_SESSION['emailplus']) && (count($_SESSION['emailplus']) > 0))) {
            if (is_array($_SESSION['email']) && (count($_SESSION['email']) > 0)) {
                foreach ($_SESSION['email'] as $key => $val) {
                    echo "<li>".$key."</li>";
                }
            }
            if (is_array($_SESSION['emailplus']) && (count($_SESSION['emailplus']) > 0)) {
                foreach ($_SESSION['emailplus'] as $key => $val) {
                    echo "<li>".$val."</li>";
                }
            }

        } else {
            ?>
            <li>Keine Adressen ausgewählt.</li>
            <?
        }
    ?>
	<li style="color:gray;"><?php echo $std_from; ?></li>
</ul>

<form action="index.php" method="post">
<input type="hidden" name="step" value="send" />
<input type="checkbox" name="check[0]" value="yes" /> Ich habe den Text überprüft.<br>
<input type="checkbox" name="check[1]" value="yes" /> Ich habe alle Anhänge angeschaut.<br>
<input type="checkbox" name="check[2]" value="yes" /> Ich habe die E-Mail-Adressen überprüft.<br>
<?php
if (!$ok_pm || !$ok_ap || !$ok_texte || !$ok_mail || !$ok_pdf || !$ok_txt) {
    ?>
    <div style="font-weight:bold;color:red;">Es gibt noch Probleme. (siehe Übersicht oben)</div>
<input <?php echo ($ok_mail) ? "" : "disabled=\"disabled\""; ?> type="submit" style="color:red;font-weight:bold;" value="Trotzdem verschicken (endgültig!)" />
    <?
} else {
?>
<input <?php echo ($ok_mail) ? "" : "disabled=\"disabled\""; ?> type="submit" style="color:red;font-weight:bold;" value="E-Mail verschicken (endgültig!)" />
<?
}
?>

</form>
</div>