<form action="index.php" method="post">
<div class="part0">
<h3>Ansprechpartner</h3>
<table>
    <tr>
        <td>Ansprechpartner 1:</td>
        <td><textarea name="ansprechpartner1"><?=htmlspecialchars($_SESSION['ansprechpartner1']);?></textarea><br><input type="checkbox" name="ap1std" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
    <tr>
        <td>Ansprechpartner 2:</td>
        <td><textarea name="ansprechpartner2"><?=htmlspecialchars($_SESSION['ansprechpartner2']);?></textarea><br><input type="checkbox" name="ap2std" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
    <tr>
        <td>Ansprechpartner 3:</td>
        <td><textarea name="ansprechpartner3"><?=htmlspecialchars($_SESSION['ansprechpartner3']);?></textarea><br><input type="checkbox" name="ap3std" value="yes" /> <small>Als Standard speichern</small><br><br></td>
    </tr>
</table>
</div>
<div class="part0"  style="text-align:right;">
<input type="hidden" name="step" value="do_edit_ap" />
<input type="submit" name="cancel" value="Abbrechen" />
<input type="submit" name="go" value="Speichern" />
</div>

</form>