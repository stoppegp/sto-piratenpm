<form action="index.php" method="post">
<div class="part0">
<h3>Ansprechpartner</h3>
<table>
    <tr>
        <td>Ansprechpartner für allgemeine Fragen:</td>
        <td><textarea name="ansprechpartner1"><?=htmlspecialchars($_SESSION['ansprechpartner1'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?></textarea><br><input type="checkbox" name="ap1std" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
    <tr>
        <td>Ansprechpartner für diese Pressemitteilung:</td>
        <td><textarea style="height:200px;"  name="ansprechpartner2"><?=htmlspecialchars($_SESSION['ansprechpartner2'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?></textarea><br><input type="checkbox" name="ap2std" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
    <tr>
        <td>Ansprechpartner 3 (keine Funktion mehr):</td>
        <td><textarea name="ansprechpartner3"><?=htmlspecialchars($_SESSION['ansprechpartner3'], ENT_COMPAT | ENT_HTML401, "ISO8859-15");?></textarea><br><input type="checkbox" name="ap3std" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
</table>
</div>
<div class="part0"  style="text-align:right;">
<input type="hidden" name="step" value="do_edit_ap" />
<input type="submit" name="cancel" value="Abbrechen" />
<input type="submit" name="go" value="Speichern" />
</div>

</form>