<div class="part0" style="text-align:center;">
<form action="index.php" method="post">
<input type="hidden" name="step" value="1" />
<input type="hidden" name="reset" value="true" />
<input type="submit" style="font-size:150%;font-weight:bold;" value="Neue PM erstellen" />
</form>
<br><br>
<form action="index.php" method="post">
<input type="hidden" name="step" value="1" />
<input type="submit" <?php if(!isset($_SESSION['start'])) echo 'disabled="disabled"';  ?>value="Mit alter Session weitermachen" />
</form>
</div>