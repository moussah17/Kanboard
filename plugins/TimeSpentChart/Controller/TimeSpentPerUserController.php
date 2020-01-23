<?php
namespace Kanboard\Plugin\TimeSpentChart\Controller;
use Kanboard\Controller\BaseController;
class TimeSpentPerUserController extends BaseController
{   
    public function timeSpentByUser(){
        $user = $this->getUser();
        $users = $this->userModel->getAll();
        $this->response->html($this->helper->layout->dashboard('TimeSpentChart:dashboard/timeSpentByUser', array(
            'title' => t('Time Spent by User'),
            'paginator' => $this->projectPagination->getDashboardPaginator($user['id'], 'projects', 25),
            'users' => $users,
            'user' => $user ,
            'selected_id' =>  0,
            'selected' => ''
        )));
    }
    public function timeSpentByUserByProject(){
        $user = $this->getUser();
        $users = $this->userModel->getAll();
        $usersNames=[];
        foreach ($users as $singleUser){
            $usersNames[$singleUser['id']] =  $singleUser['username'];

        }
       $this->response->html($this->helper->layout->dashboard('TimeSpentChart:dashboard/timeSpentByUserByProject', array(
            'title' => t('By project'),
            'paginator' => $this->projectPagination->getDashboardPaginator(0, 'projects', 25),
            'users' => $usersNames,
            'user' => $user,
            'selected_id' =>  0,            
            'selected' => ''

        )));
    }


    public function getProjects(){
        $user = $this->getUser();
        $users = $this->userModel->getAll();
        $usersNames=[];
        $user_id=$_GET['user_id'];
        foreach ($users as $singleUser){
            $usersNames[$singleUser['id']] =  $singleUser['username'];
        }
        $this->response->html($this->helper->layout->dashboard('TimeSpentChart:dashboard/timeSpentByUserByProject', array(
            'title' => t('By project'),
            'paginator' => $this->projectPagination->getDashboardPaginator($user_id, 'projects', 25),
            'users' => $usersNames,
            'user' => $user,
            'selected_id' =>  $user_id,
            'selected' =>  $usersNames[$user_id] 
        )));
    }




    public function showProjectChart(){
        $user = $this->getUser();
        $users = $this->userModel->getAll();
        $usersNames=[];
        $user_id=$_GET['user_id'];
        $resultArray=array();
        $timeSpentProject=0;
        if($_POST['selected_project']){
            $selectedProject=$_POST['selected_project'];
            $selectedUserId = $_GET['user_id'];
            $timeSpentProject=$this->timeSpentPerUserModel->getTimespentPerUserSum($selectedUserId, $selectedProject);
            $taskarray=$this->timeSpentPerUserModel->getTimespentPerProject($selectedProject);
         foreach($taskarray as $singleTask){
             $pourcentage=$this ->calculatePourcentage($timeSpentProject,$singleTask['time_spent']);
             array_push ($resultArray,array('spent'=>intval($singleTask['time_spent']) ,'percentage'=>floatval($pourcentage) , 'task'=>$singleTask['title'] ));
            }    
        }
        $this->response->html($this->helper->layout->dashboard('TimeSpentChart:dashboard/donut-project-page', array(
            'title' => t('By project'),
            'user' => $user,
            'timeSpent' => $timeSpentProject,
            'metrics' => $resultArray,
            'paginator' => $this->projectPagination->getDashboardPaginator($user_id, 'projects', 25),
            
        )));
    }
    public function calculatePourcentage($totalSpent,$oneTaskSpent){
        $result=number_format((float)0, 2, '.', '');
        if($totalSpent !=0){
            $result= number_format((float)($oneTaskSpent*100)/$totalSpent, 2, '.', '');
        }
        return $result;
       
    }

    public function initDatesArray($startDate,$endDate){
        $result =array();
        for($singleDate=date("Y-m-d", $startDate);$singleDate<=date("Y-m-d", $endDate);$singleDate++){
            $result[$singleDate]=array('timeSpent' =>0 ,'title' => $singleDate);
        }
        return $result;
    }
      public function update()
    {
        if ($_POST['selected_user']) {
            $selectedUserId = $_POST['selected_user'];
            $startDate = strtotime($_POST['start_date']);
            $endDate = strtotime($_POST['end_date']);;
            $timeSpentInByDate = $this->timeSpentPerUserModel->getTimespentPerUser($selectedUserId, $startDate, $endDate);
            $timeSpentInHours=0;
            $sameDate=date('Y-m-d');
            $timeSpentThatDate=0;
            $selectedProject=0;
            $datesArray=$this->initDatesArray($startDate,$endDate); 
            
           if($timeSpentInByDate!=null){
            foreach($timeSpentInByDate as $perday) 
            {
                for($singleDate=date("Y-m-d", $startDate);$singleDate<=date("Y-m-d", $endDate);$singleDate++){
                $timeSpentInHours+=$perday['time_spent'];
                $date=date('Y-m-d',$perday['end']);
                
                if(date("Y-m-d", $perday['end'])!=$sameDate){
                    $sameDate=date("Y-m-d", $perday['end']);
                    $timeSpentThatDate=0;
                }
                $timeSpentThatDate +=$perday['time_spent'];
                $datesArray[$date]=array('timeSpent' =>$timeSpentThatDate ,'title' => $date);
            }}
                }
            $user = $this->getUser();
            $SUser = $this->userModel->getById(2);
         
          
         $this->response->html($this->helper->layout->dashboard('TimeSpentChart:dashboard/chart-page', array(
            'title' => t('Projects overview for %s', $this->helper->user->getFullname($user)),
            'paginator' => $this->projectPagination->getDashboardPaginator($user['id'], 'projects', 25),
            'user' => $user,
            'dates' => $datesArray,
            'timeSpentInHours' => $timeSpentInHours,
            'start' =>$startDate,
            'end' =>$endDate,
        )));
}
    }
}
?>