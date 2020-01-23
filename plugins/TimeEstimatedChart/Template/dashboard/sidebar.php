<li <?= $this->app->checkMenuSelection('TimeEstimatedPerUserController', 'timeEstimatedByUser','TimeEstimatedChart') ?>>
            <?= $this->url->link(t('Time Estimated By User (plugin)'), 'TimeEstimatedPerUserController', 'timeEstimatedByUser', array('plugin' => 'TimeEstimatedChart','user_id' => $user['id'])) ?>
</li>