<li <?= $this->app->checkMenuSelection('TimeSpentPerUserController', 'timeSpentByUser','TimeSpentChart') ?>>
        <div class="dropdown header-creation-menu">
        <a href="#" class="dropdown-menu dropdown-menu-link-icon">time spent by user <i class="fa fa-caret-down"></i></a>
        <ul>
            
                <li <?= $this->app->checkMenuSelection('TimeSpentPerUserController', 'timeSpentByUser','TimeSpentChart') ?>>
                    <?= $this->url->link(t('By date'), 'TimeSpentPerUserController', 'timeSpentByUser', array('plugin' => 'TimeSpentChart','user_id' => $user['id'])) ?>
                </li>
        
          
                <li <?= $this->app->checkMenuSelection('TimeSpentPerUserController', 'timeSpentByUser','TimeSpentChart') ?>>
                    <?= $this->url->link(t('By project'), 'TimeSpentPerUserController', 'timeSpentByUserByProject', array('plugin' => 'TimeSpentChart','user_id' => $user['id'])) ?>
                </li>
          
          
        </ul>
    </div>
</li>

