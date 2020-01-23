<div class="page-header">
    <h2><?= $this->url->link(t('My estimated time diagram'), 'DashboardController', 'diagram', array('user_id' => $user['id'])) ?> (<?= $paginator->getTotal() ?>)</h2>
</div>
<div class="panel">
<li><?= t('From: ').'<strong>'.$this->text->e(date("Y-m-d",$start)).'</strong>'.t(' to: ').'<strong>'.$this -> text -> e(date("Y-m-d",$end)) ?></strong></li>

        

</div>

<?= $this->app->component('chart-project-time-estimated', array(
            'metrics' => $dates,
            'label' => $labels,
            'estimated' => $estimated,
        )) ?>
<br>
<br>
<table class="table-striped">
        <tr>
        <th>Date</th>
        <?php foreach ($dates as $key => $date): ?>
        
            <td>
                <?= $this->text->e(($key)) ?>
            </td>
        <?php endforeach ?>
            <th>Total</th>
            </tr>
            <tr>
            <th>time Estimated</th>
            <?php $som=0 ?>    
            <?php foreach ($dates as $date): ?>
            <?php $som=$som+2; ?>
            <td>
                <?= $this->text->e($date['estimated']) ?>
            </td>
        <?php endforeach ?>
                <td><?=$som ?></td>
            </tr>


</table>

       
