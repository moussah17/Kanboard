<?php
namespace Kanboard\Plugin\TimeSpentChart;
use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\TimeSpentChart\Model\TimeSpentPerUserModel;
class Plugin extends Base
{
    public function initialize()
    {
        $this->hook->on('template:layout:js', array('template' => 'plugins\TimeSpentChart\Assets\components\chart-project-task.js'));
        $this->hook->on('template:layout:js', array('template' => 'plugins\TimeSpentChart\Assets\components\chart-project-time-spent.js'));
        $this->template->hook->attach('template:dashboard:sidebar', 'TimeSpentChart:dashboard\sidebar');        
    }
    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }
    public function getClasses()
    {
        return array(
            'Plugin\TimeSpentChart\Model' => array(
                'TimeSpentPerUserModel'),
            'Plugin\TimeSpentChart\Controller' => array(
            'TimeSpentPerUserController'),
        );
    }
    public function getPluginName()
    {
        return 'TimeSpentChart';
    }
    public function getPluginDescription()
    {
        return t('display the time spent by users between 2 days');
    }
    public function getPluginAuthor()
    {
        return 'Moussa Hadj-aissa';
    }
    public function getPluginVersion()
    {
        return '1.0.3';
    }
    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-TimeSpentPerUser';
    }
    public function getCompatibleVersion()
    {
        return '>=0';
    }
}