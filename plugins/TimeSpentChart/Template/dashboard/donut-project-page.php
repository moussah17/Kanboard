<div class="page-header">
    <h2><?= $this->url->link(t('My spent time diagram'), 'DashboardController', 'diagram', array('user_id' => $user['id'])) ?> (<?= $paginator->getTotal() ?>)</h2>
</div>
<div class="panel">
<li><?= t('Project: ').'<strong>'.$this->text->e("mon projet") ?></strong></li>
<li><?= t('Time spent by hours: ').'<strong>'.$this->text->e($timeSpent) ?></strong></li>
</div>

<?php if (empty($metrics)): ?>
    <p class="alert"><?= t('Not enough data to show the graph') ?></p>
<?php else:     ?>
    <?= $this->app->component('chart-project-task', array(
        'metrics' => $metrics,
    )) ?>
    <table class="table-striped">
        <tr>
            <th><?= t('Task') ?></th>
            <th><?= t('Time spent') ?></th>
            <th><?= t('Percentage') ?></th>
        </tr>
        <?php foreach ($metrics as $metric): ?>
        <tr>
            <td>
                <?= $this->text->e($metric['task']) ?>
            </td>
            <td>
                <?= $metric['spent'] ?>
            </td>
            <td>
                <?= n($metric['percentage']) ?>%
            </td>
        </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>
