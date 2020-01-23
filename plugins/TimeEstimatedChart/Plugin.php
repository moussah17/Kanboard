<?php
namespace Kanboard\Plugin\TimeEstimatedChart;
use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\TimeEstimatedChart\Model\TimeEstimatedPerUserModel;
class Plugin extends Base
{
    public function initialize()
    {

        $this->hook->on('template:layout:js', array('template' => 'plugins\TimeEstimatedChart\Assets\components\chart-project-time-estimated.js')); 
        $this->template->hook->attach('template:dashboard:sidebar', 'TimeEstimatedChart:dashboard\sidebar');
    }
    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }
    public function getClasses()
    {
        return array(
            'Plugin\TimeEstimatedChart\Model' => array(
                'TimeEstimatedPerUserModel',
            ),
            'Plugin\TimeEstimatedChart\Controller' => array(
            'TimeEstimatedPerUserController'),
        );
    }
    public function getPluginName()
    {
        return 'TimeEstimatedChart';
    }
    public function getPluginDescription()
    {
        return t('display the time Estimated by users');
    }
    public function getPluginAuthor()
    {
        return 'Moussa Hadj-aissa';
    }
    public function getPluginVersion()
    {
        return '0';
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