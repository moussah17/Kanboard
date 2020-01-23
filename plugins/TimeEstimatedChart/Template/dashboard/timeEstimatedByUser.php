<form method="post" action="<?= $this->url->href('TimeEstimatedPerUserController', 'sendData',array('plugin' => 'TimeEstimatedChart')) ?>" autocomplete="off">

    
    
    <label>Projects organization : </label>
    <input type="radio" name="hoursPerDay" value="irregular"/>irregular
    <input type="radio" name="hoursPerDay" onclick="yesnoCheck();" value="regular"/>regular
    
    <input type="text" name="perDay" >
    <br>
    <br>
    <?php if ($users): ?>
    <select name="selected_user">
        <?php foreach ($users as $singleUser): ?>file_get_contents
          <?php echo "<option value=" . $singleUser['id'] . ">" . $singleUser['username'] . "</option>" ?>
        <?php endforeach ?>
    </select>
<?php endif ?>
<?php $date = date('Y-m-d') ."T" . "00:00";?>

<label>Start date</label>
<input type="datetime-local" name="start_date" value="<?php echo $date?>">

<label>End date</label>
<input type="datetime-local" name="end_date" value="<?php echo date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $date))) ) . "T" . "00:00" ?>">

    
<input type="submit" value="submit">

</form>

<script type="text/javascript">
function yesnoCheck() {
  
    alert();
  
}
</script>