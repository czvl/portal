<?php

/**
 * Created by A.Belyakovskiy.
 * Date: 5/10/15
 * Time: 11:03 PM
 */
class CvListHelper
{
    public static function statusStatistic($addedTimeFrom = null, $addedTimeTo = null)
    {
        $result = [];

        $types = CvList::model()->getStatusTypes();

        $command = Yii::app()->db->cache(60)
            ->createCommand()
            ->select('status, count(id) cnt')
            ->from(CvList::model()->tableName())
            ->group('status');

        if ($addedTimeFrom) {
            $command->andWhere('added_time >= "' . date('Y-m-d 00:00:00', strtotime($addedTimeFrom)) . '"');
        }
        if ($addedTimeTo) {
            $command->andWhere('added_time <= "' . date('Y-m-d 23:59:59', strtotime($addedTimeTo)) . '"');
        }

        $rows = $command->queryAll();

        if (is_array($rows)) {
            foreach ($rows as $row) {
                $result[] = [
                    'name' => $types[$row['status']],
                    'count' => $row['cnt'],
                ];
            }
        }

        return $result;
    }

}