<form action="index.php" method="post">
<div class="part0">
<h3>Ziel-Adressen</h3>
<table>
    <tr>
        <td>Adressen:</td>
        <td>
            <?php
            
                foreach ($mailadressen as $val) {
                    if (is_array($_SESSION['email']) && in_array($val, array_keys($_SESSION['email']))) {
                        echo '<input type="checkbox" checked="checked" name="email['.$val.']" /> '.$val.'<br>';
                    } else {
                        echo '<input type="checkbox" name="email['.$val.']" /> '.$val.'<br>';
                    }
                }
            
            ?>
        </td>
    </tr>
    <tr>
        <td>Weitere Adressen:</td>
        <td>
            <textarea name="emailplus"><?php echo htmlspecialchars(implode("\n", $_SESSION['emailplus'])); ?></textarea><br>
            <small>Eine E-Mail-Adresse pro Zeile</small><br>
            <small>Bitte die E-Mail auch an info@piratenpartei-gp.de schicken</small>
        </td>
    </tr>
</table>
</div>
<div class="part0"  style="text-align:right;">
<input type="hidden" name="step" value="do_edit_mail" />
<input type="submit" name="cancel" value="Abbrechen" />
<input type="submit" name="go" value="Speichern" />
</div>

</form>