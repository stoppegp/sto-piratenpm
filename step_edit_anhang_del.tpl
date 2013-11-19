<form action="index.php" method="post">
<div class="part0">
<h3>Anhänge entfernen</h3>
<ul>
<?php   
    if (is_array($_SESSION['anhang']) && (count($_SESSION['anhang']) > 0)) {
        foreach ($_SESSION['anhang'] as $key => $val) {
            echo "<li><input type=\"checkbox\" name=\"delanhang[$key]\" value=\"1\" /> <a target=\"_blank\" href=\"out/".session_id()."/anhang/".$val."\">".$val."</a></li>";
        }
    }
?>
</ul>
</div>
<div class="part0"  style="text-align:right;">
<input type="hidden" name="step" value="do_edit_anhang_del" />
<input type="submit" name="cancel" value="Abbrechen" />
<input type="submit" name="go" value="Speichern" />
</div>

</form>