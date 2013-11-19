<form action="index.php" method="post">
<div class="part0">
<h3>Texte</h3>
<table>
    <tr>
        <td>Mail-Anschreiben:</td>
        <td><textarea name="anschreiben" style="width:500px;height:350px;"><?=htmlspecialchars($_SESSION['anschreiben']);?></textarea><br><input type="checkbox" name="anschreibenstd" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
    <tr>
        <td>Mail-Footer:</td>
        <td><textarea name="footer" style="width:500px;height:150px;"><?=htmlspecialchars($_SESSION['footer']);?></textarea><br><input type="checkbox" name="footerstd" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
</table>
</div>
<div class="part0"  style="text-align:right;">
<input type="hidden" name="step" value="do_edit_texte" />
<input type="submit" name="cancel" value="Abbrechen" />
<input type="submit" name="go" value="Speichern" />
</div>

</form>