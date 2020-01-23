<div class="page-header">
    <h2><?= $this->url->link(t('My spent time diagram'), 'DashboardController', 'diagram', array('user_id' => $user['id'])) ?> (<?= $paginator->getTotal() ?>)</h2>
</div>
<div class="panel">
<li><?= t('From: ').'<strong>'.$this->text->e(date("Y-m-d",$start)).'</strong>'.t(' to: ').'<strong>'.$this -> text -> e(date("Y-m-d",$end)) ?></strong></li>
<li><?= t('Time spent by hours: ').'<strong>'.$this->text->e($timeSpentInHours) ?></strong></li>
        

</div>

<?= $this->app->component('chart-project-time-spent', array(
            'metrics' => $dates,
            'label' => t('Hours Spent'),
        )) ?>
<br>
<br>
<table class="table-striped">
        <tr>
        <th>Date</th>
        <?php foreach ($dates as $date): ?>
        
            <td>
                <?= $this->text->e($date['title']) ?>
            </td>
        <?php endforeach ?>
            <th>Total</th>
            </tr>
            <tr>
            <th>time spent</th>
            <?php $som=0 ?>    
            <?php foreach ($dates as $date): ?>
            <?php $som=$som+$date['timeSpent']; ?>
            <td>
                <?= $this->text->e($date['timeSpent']) ?>
            </td>
        <?php endforeach ?>
                <td><?=$som ?></td>
            </tr>


</table>

       
