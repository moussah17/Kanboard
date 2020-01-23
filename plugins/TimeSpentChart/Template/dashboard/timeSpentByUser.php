<form method="post" action="<?= $this->url->href('TimeSpentPerUserController', 'update',array('plugin' => 'TimeSpentChart')) ?>" autocomplete="off">
    <?php if ($users): ?>


    <select name="selected_user" id="mySelect" >
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
    document.getElementById('perDay').style.display = 'block';
    alert();
  
}
</script>
<script src="plugins\TimeSpentChart\Assets\js\myFunctions.js"></script>
