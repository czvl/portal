<?php
/**
 * @var $dataProvider CDataProvider
 */
?>

<p class="lead">
    Профілі, в яких не заповнені категорії, можливі посади, місто роботи чи проживання
</p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=> $dataProvider,
    'columns'=>[
        [
            'name' => CvList::model()->getAttributeLabel('first_name'),
            'type' => 'raw',
            'value' => function(CvList $cvList) {
                return CHtml::link($cvList->first_name. " " . $cvList->last_name, [
                    'update', 'id' => $cvList->id
                ]);
            }
        ],
        [
            'name' => CvList::model()->getAttributeLabel('status'),
            'value' => function(CvList $cvList) {
                return $cvList->statusTypes[$cvList->status];
            }
        ],
        [
            'name' => CvList::model()->getAttributeLabel('categoryIds'),
            'value' => function(CvList $cvList) {
                return !empty($cvList->categories) ? '+' : '-';
            }
        ],
        [
            'name' => CvList::model()->getAttributeLabel('positionsIds'),
            'value' => function(CvList $cvList) {
                return !empty($cvList->positions) ? '+' : '-';
            }
        ],
        [
            'name' => CvList::model()->getAttributeLabel('jobLocationsIds'),
            'value' => function(CvList $cvList) {
                return !empty($cvList->citiesJobLocations) ? '+' : '-';
            }
        ],
        [
            'name' => CvList::model()->getAttributeLabel('residenciesIds'),
            'value' => function(CvList $cvList) {
                return !empty($cvList->citiesResidence) ? '+' : '-';
            }
        ],
        [
            'name' => CvList::model()->getAttributeLabel('recruiter'),
            'value' => function(CvList $cvList) {
                $recruiter = $cvList->recruiter;
                if(!empty($recruiter)) {
                    return  CHtml::link($cvList->recruiter->firstLastName, [
                        '/manage/reqruiter',
                        'id' => $cvList->recruiter->id,
                    ]);
                }

                return null;
            },
            'type' => 'raw',
        ],
        'added_time:datetime',
        'last_update:datetime',
    ],
));?>
