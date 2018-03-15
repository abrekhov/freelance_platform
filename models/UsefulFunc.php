<?php

namespace app\modules\freelance\models;

use Yii;

/**
 * This is the model class for table "bids".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $price
 * @property integer $deadline
 * @property string $comment
 * @property integer $uid
 * @property string $dateup
 */
class UsefulFunc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function prettyTime($time)
    {
		date_default_timezone_set('Europe/Moscow');
        $month_name = 
            array( 1 => 'января',
                   2 => 'февраля',
                   3 => 'марта',
                   4 => 'апреля',
                   5 => 'мая',
                   6 => 'июня',
                   7 => 'июля',
                   8 => 'августа',
                   9 => 'сентября',
                   10 => 'октября',
                   11 => 'ноября',
                   12 => 'декабря'
       );

                $month = $month_name[ date( 'n',$time ) ];

                $day   = date( 'j',$time );
                $year  = date( 'Y',$time );
                $hour  = date( 'G',$time );
                $min   = date( 'i',$time );

                $date = $day . ' ' . $month . ' ' . $year . ' г. в ' . $hour . ':' . $min;

                $dif = time()- $time;

                if($dif<59){
                    return $dif." сек. назад";
                }elseif($dif/60>1 and $dif/60<59){
                    return round($dif/60)." мин. назад";
                }elseif($dif/3600>1 and $dif/3600<23){
                    return round($dif/3600)." час. назад";
                }elseif($dif/(3600*24)>1 and $dif/(3600*24)<7){
                    return round($dif/(3600*24))." дн. назад";
                }elseif($dif/(3600*24*7)>1 and $dif/(3600*24*7)<4){
                    return round($dif/(3600*24*7))." нед. назад";
                }elseif($dif/(3600*24*30)>1 and $dif/(3600*24*30)<12){
                    return round($dif/(3600*24*30))." мес. назад";
                }else{
                    return $date;
                }
    }
    
    
}
?>