<?php
namespace Kanboard\Plugin\MailPlugin;
use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
class Plugin extends Base
{
    public function initialize()
    {  
        $this->hook->on('kanboard:notification:comment_create', array('template' => 'plugins\MailPlugin\Template\notification\link_to_task.php')); 
        $this->template->hook->attach('template:notification', 'MailPlugin:notification\link_to_task');
            }
    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }
    public function getClasses()
    {
        return array();
    }
    public function getPluginName()
    {
        return 'MailPlugin';
    }
    public function getPluginDescription()
    {
        return t('Add the link of the task on the mail notification');
    }
    public function getPluginAuthor()
    {
        return 'Moussa Hadj-aissa';
    }
    public function getPluginVersion()
    {
        return '0.0.1';
    }
    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/mailPlugin';
    }
    public function getCompatibleVersion()
    {
        return '>=1.2.3';
    }
}