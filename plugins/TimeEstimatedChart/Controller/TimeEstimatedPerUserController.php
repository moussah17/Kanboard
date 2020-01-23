<?php

namespace Kanboard\Plugin\TimeEstimatedChart\Controller;

use Kanboard\Controller\BaseController;

class TimeEstimatedPerUserController extends BaseController
{
    public function timeEstimatedByUserSchedule()
    {
        $user = $this->getUser();
        $users = $this->userModel->getAll();
        $this->response->html($this->helper->layout->dashboard('TimeEstimatedChart:dashboard/timeEstimatedByUserSchedule', array(
            'title' => t('Time Estimated by User'),
            'users' => $users,
            'user' => $user,
            'paginator' => $this->projectPagination->getDashboardPaginator($user['id'], 'projects', 25),
        )));
    }
    public function timeEstimatedByUser()
    {
        $user = $this->getUser();
        $users = $this->userModel->getAll();
        $this->response->html($this->helper->layout->dashboard('TimeEstimatedChart:dashboard/timeEstimatedByUser', array(
            'title' => t('Time Estimated by User'),
            'users' => $users,
            'user' => $user,
            'paginator' => $this->projectPagination->getDashboardPaginator($user['id'], 'projects', 25),
        )));
    }


    public function initDatesPlanningArray($startDate,$endDate,$tasksList)
    {
        for ($singleDate = date("Y-m-d", $startDate); $singleDate <= date("Y-m-d", $endDate); $singleDate++) {
            $tasks=array();
            foreach($tasksList as $task){
                $tasks[$task['title']]=0;
            }
            $result[$singleDate]=array('tasks' =>$tasks, 'estimated_total'=> 8 );
         }
         return $result;
    }


    public function timeSubtract($idSubtask,$tasksList,$timeEstimatedSubstracted){    
        
        for($i = 0; $i<sizeof($tasksList) ;$i++){
            $task = $tasksList[$i];
            if ($idSubtask == $task['id']) {
                $task['time_estimated']=$task['time_estimated'] - $timeEstimatedSubstracted;
                $tasksList[$i]=$task;
            }
        }
        return $tasksList;
    }


    
    public function generateLabeslArray($array){
        $result=array();
        foreach($array as $columnId){
            $tasks=$columnId['tasks'];
            foreach($tasks as $key => $task){
                array_push($result,$key,$task); 
            }

        }
        return $result;
    }

    public function generateEstimatedArray($array){
        $result=array();
        foreach($array as $columnId){
            $tasks=$columnId['tasks'];
            foreach($tasks as $task){
                $result[]=$task; 
            }      
        }
        return $result;
    }
    
    public function generateDatesArray($array){
        $result=array();
        foreach($array as $key=> $columnId){
            $result[$key]=array('estimated' =>8-$columnId['estimated_total'],'tasks'=> $columnId['tasks']);
        }
        return $result;
        
    }

    public function ProgressTasks($tasksList){
        $result =array();
        foreach($tasksList as $task){
            $columnTitle=$this ->  timeEstimatedPerUserModel -> getColumnName($task['column_id']);
            if($columnTitle == 'Work in progress'){
                array_push($result,$task);
            }

        }
return $result;
    }


    public function initTasks($startDate,$endDate,$tasksList){
        $result=array();
        for ($singleDate = date("Y-m-d", $startDate); $singleDate <= date("Y-m-d", $endDate); $singleDate++) {
            foreach($tasksList as $task){
                $result[$singleDate][$task['title']]=0; 
            }

        }
return $result;
    }

    public function sendData()
    {
        if ($_POST['selected_user']) {
            $selectedUserId = $_POST['selected_user'];
            $startDate = strtotime($_POST['start_date']);
            $endDate = strtotime($_POST['end_date']);
            $tasksListAll = $this->timeEstimatedPerUserModel->getTimespentPerUser($selectedUserId, $startDate, $endDate);
            $tasksList=$this ->ProgressTasks($tasksListAll);
            $timeEstimatestInHours = 0;
            $datesArray=$this->initDatesPlanningArray($startDate,$endDate,$tasksList);
            if ($tasksList != null) {
            $tasks=$this ->initTasks($startDate,$endDate,$tasksList);
            if($_POST['perDay']){
                $HourPerDay=intval($_POST['perDay']);
            }else {
                $HourPerDay=9999;
            }
            foreach($tasksList as $slectedTask){
            for ($singleDate = date("Y-m-d", $startDate); $singleDate <= date("Y-m-d", $endDate); $singleDate++) {
                    $selectedDateEstimation=$datesArray[$singleDate];
                if(intval($selectedDateEstimation['estimated_total']) > 0 && intval($slectedTask['time_estimated'])>0){
                    $selectedTaskEsimated=intval($slectedTask['time_estimated']);
                    $selectedDateEstimatedTime=intval($selectedDateEstimation['estimated_total']);
                    //echo '---------- '.($selectedDateEstimatedTime);
                    $selectedTaskTitle=$slectedTask['title']; 
                    echo 'daaaaaamp '.$selectedTaskEsimated.' Vs '.$selectedDateEstimatedTime;
                    echo '<br>'.$selectedTaskTitle;
                    if($selectedTaskEsimated >= $selectedDateEstimatedTime){
                        if($selectedDateEstimatedTime >= $HourPerDay){
                            echo 'zzzz '.$HourPerDay;
                            $tasks[$singleDate][$selectedTaskTitle]=$HourPerDay;
                            $datesArray[$singleDate] = array('tasks'=> $tasks[$singleDate],
                            'estimated_total' => $selectedDateEstimatedTime-$HourPerDay); 
                            $tasksList= $this-> timeSubtract($slectedTask['id'],$tasksList,$HourPerDay);
                            $slectedTask['time_estimated']=$slectedTask['time_estimated']-$HourPerDay;
                        }else{
                            $tasks[$singleDate][$selectedTaskTitle]=intval($selectedDateEstimatedTime);
                            $datesArray[$singleDate] = array('tasks'=> $tasks[$singleDate],'estimated_total' => 0 );
                            $tasksList= $this-> timeSubtract($slectedTask['id'],$tasksList,$selectedTaskEsimated);
                            $slectedTask['time_estimated']=$slectedTask['time_estimated']-$selectedTaskEsimated;
                            }
                    }else{
                        if($selectedTaskEsimated >=$HourPerDay ){
                            $tasks[$singleDate][$selectedTaskTitle]=$HourPerDay;
                            $datesArray[$singleDate] = array('tasks'=> $tasks[$singleDate],
                            'estimated_total' =>($selectedDateEstimatedTime -$HourPerDay));
                            $tasksList=  $this-> timeSubtract($slectedTask['id'],$tasksList,$HourPerDay);
                            $slectedTask['time_estimated']=$slectedTask['time_estimated']-$HourPerDay;
                        }else{
                            $tasks[$singleDate][$selectedTaskTitle]=intval($selectedTaskEsimated);
                            $datesArray[$singleDate] = array('tasks'=> $tasks[$singleDate],
                            'estimated_total' =>($selectedDateEstimatedTime -$selectedTaskEsimated));
                            $tasksList=  $this-> timeSubtract($slectedTask['id'],$tasksList,($selectedTaskEsimated));
                            $slectedTask['time_estimated']=$slectedTask['time_estimated']-$selectedTaskEsimated;
                        }
                    }
                }
                }
            }

                echo 'success ';
                echo ''.var_dump($slectedTask);
                }else {
                for ($singleDate = date("Y-m-d", $startDate); $singleDate <= date("Y-m-d", $endDate); $singleDate++) {
                    $datesArray[$singleDate] = array('timeSpent' => 0, 'title' => $singleDate);
                }
            }

            $lables=$this -> generateLabeslArray($datesArray);
            $estimated=$this -> generateEstimatedArray($datesArray);
            $datesArray = $this -> generateDatesArray($datesArray);
            $user = $this->getUser();
            $this->response->html($this->helper->layout->dashboard('TimeEstimatedChart:dashboard/chart-page', array(
                'title' => t('Projects overview for %s', $this->helper->user->getFullname($user)),
                'paginator' => $this->projectPagination->getDashboardPaginator($user['id'], 'projects', 25),
                'user' => $user,
                'labels' => $lables,
                'estimated' =>$estimated ,
                'dates' => $datesArray,
                'timeEstimatedInHours' => $timeEstimatestInHours,
                'start' => $startDate,
                'end' => $endDate,
            )));
        }
    
}
}