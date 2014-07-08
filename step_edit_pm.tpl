<form action="index.php" method="post">
<div class="part0">
<h3>Pressemitteilung bearbeiten</h3>
<table>
    <tr>
        <td>Datum:</td>
        <td><input name="datum" value="<?=htmlspecialchars($_SESSION['datum'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?>" /></td>
    </tr>
    <tr>
        <td>Titel:</td>
        <td><input name="titel" id="pmtitel" style="width:500px;" value="<?=htmlspecialchars($_SESSION['titel'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?>" /></td>
    </tr>
    <tr>
        <td>Text:</td>
        <td><textarea name="text" id="pmtext" style="width:500px;height:500px;"><?=$_SESSION['text'];?></textarea></td>
    </tr>
</table>
</div>
<div class="part0"  style="text-align:right;">
<input type="hidden" name="step" value="do_edit_pm" />
<input type="submit" name="cancel" value="Abbrechen" />
<input type="submit" name="go" value="Speichern" />
</div>

</form>