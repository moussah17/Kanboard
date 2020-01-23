<?php
namespace Kanboard\Plugin\TimeEstimatedChart\Model;
use DateTime;
use Kanboard\Core\Base;

/**
 * Subtask time tracking
 *
 * @package  Kanboard\Model
 * @author   Frederic Guillot
 */
class TimeEstimatedPerUserModel extends Base
{
    /**
     * SQL table name
     *
     * @var string
     */
    const TABLE = 'tasks';
    const TABLE1 = 'columns';
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
            ->eq(self::TABLE.'.owner_id', $userId)
            ->asc('prioirity') -> findAll();
    }
    public function getColumnName($columnId)
    {
        return $this->db
            ->table(self::TABLE1)
            ->eq(self::TABLE1.'.id', $columnId)
            ->findOneColumn('title');
    }


}
