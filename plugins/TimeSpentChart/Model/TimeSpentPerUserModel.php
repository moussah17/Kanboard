<?php
namespace Kanboard\Plugin\TimeSpentChart\Model;
use DateTime;
use Kanboard\Core\Base;

/**
 * Subtask time tracking
 *
 * @package  Kanboard\Model
 * @author   Frederic Guillot
 */
class TimeSpentPerUserModel extends Base
{
    /**
     * SQL table name
     *
     * @var string
     */
    const TABLE = 'subtask_time_tracking';
    const TABLETASK = 'tasks';

  /**
     * Time spent by user between 2 dates
     *
     * @access public
     * @param  integer   $userId    User id
     * @param  integer   $startDate    Start date
     * @param  integer   $endDate    end date
     * @return array
     */
    public function getTimespentPerUser($userId, $startDate, $endDate)
    {
        return $this->db
            ->table(self::TABLE)
            ->eq(self::TABLE.'.user_id', $userId)
            ->gt(self::TABLE.'.start', $startDate)
            ->lt(self::TABLE.'.end', $endDate)
            ->findAll();
    }

    public function getTimespentPerProject($projectId)
    {
        return $this->db
            ->table(self::TABLETASK)
            ->eq(self::TABLETASK.'.project_id', $projectId)
            ->findAll();
    }

    public function getTimespentPerUserSum($userId,$projectId)
    {
        return $this->db
            ->table(self::TABLETASK)
            ->eq(self::TABLETASK.'.project_id', $projectId)
            ->sum('time_spent');   
         }
}
