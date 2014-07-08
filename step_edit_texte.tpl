<form action="index.php" method="post">
<div class="part0">
<h3>Texte</h3>
<table>
    <tr>
        <td>Mail-Anschreiben:</td>
        <td><textarea name="anschreiben" style="width:500px;height:350px;"><?=htmlspecialchars($_SESSION['anschreiben'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?></textarea><br><input type="checkbox" name="anschreibenstd" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
    <tr>
        <td>Mail-Footer:</td>
        <td><textarea name="footer" style="width:500px;height:150px;"><?=htmlspecialchars($_SESSION['footer'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?></textarea><br><input type="checkbox" name="footerstd" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
    <tr>
        <td>Treffen (PDF):</td>
        <td><textarea name="treffen" style="width:500px;height:150px;"><?=htmlspecialchars($_SESSION['treffen'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?></textarea><br><input type="checkbox" name="treffenstd" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
    <tr>
        <td>Anschrift (PDF):</td>
        <td><textarea name="anschrift" style="width:500px;height:150px;"><?=htmlspecialchars($_SESSION['anschrift'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?></textarea><br><input type="checkbox" name="anschriftstd" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
    <tr>
        <td>Alternativer Betreff:</td>
        <td><input type="text" name="betreff" value="<?=htmlspecialchars($_SESSION['betreff'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?>" /></td>
    </tr>
</table>
</div>
<div class="part0"  style="text-align:right;">
<input type="hidden" name="step" value="do_edit_texte" />
<input type="submit" name="cancel" value="Abbrechen" />
<input type="submit" name="go" value="Speichern" />
</div>

</form>