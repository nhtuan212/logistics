<?php
    class Statistic extends Functions
    {
        public function __construct($d)
        {
            $this->db = $d;
            $this->counter();
        }
        public function counter(){
            $now = time();
            $locktime = 15;
            $initialvalue = 1;
            $records = 100000;
            $locktime = $locktime * 60;

            $ip = $_SERVER['REMOTE_ADDR'];
            $t = $this->db->rawQueryOne("SELECT count(id) AS total FROM table_counter");
            $all_visitors = $t['total'];

            if($all_visitors !== NULL) $all_visitors += $initialvalue;
            else $all_visitors = $initialvalue;
            $temp = $all_visitors - $records;
            if($temp>0) $this->db->rawQuery("delete FROM #_counter WHERE id<?",array($temp));
            
            $vip = $this->db->rawQueryOne("select COUNT(*) AS visitip FROM #_counter WHERE ip='$ip' AND (tm+'$locktime')>'$now'");
            $items = $vip['visitip'];
            if(empty($items)) {
                $data['tm'] = $now;
                $data['ip'] = $ip;
                $this->db->insert('counter', $data);
            }
        }
        public function getCounter(){
            $day = date('d');
            $month = date('n');
            $year = date('Y');
            $daystart = mktime(0,0,0,$month,$day,$year);
            $yesterdaystart = $daystart - 86400;
            $monthstart = mktime(0,0,0,$month,1,$year);
            $weekday = date('w');
            $weekday--;
            if($weekday < 0) $weekday = 7;
            $weekday = $weekday * 86400;
            $weekstart = $daystart - $weekday;

            $yesrec = $this->db->rawQueryOne("select COUNT(*) AS yesterdayrec FROM #_counter WHERE tm>? and tm<?", array($yesterdaystart, $daystart));
            $todayrec = $this->db->rawQueryOne("select COUNT(*) AS todayrecord FROM #_counter WHERE tm>?", array($daystart));
            $weekrec = $this->db->rawQueryOne("select COUNT(*) AS weekrec FROM #_counter WHERE tm>=?", array($weekstart));
            $monthrec = $this->db->rawQueryOne("select COUNT(*) AS monthrec FROM #_counter WHERE tm>=?", array($monthstart));
            $totalrec = $this->db->rawQueryOne("select MAX(id) AS total FROM #_counter");

            $result['yesterday'] = $yesrec['yesterdayrec']; 
            $result['today'] = $todayrec['todayrecord']; 
            $result['week'] = $weekrec['weekrec']; 
            $result['month'] = $monthrec['monthrec']; 
            $result['total'] = $totalrec['total'];
            return $result;
        }
        public function onlineCounter(){
            global $d;
            $time = 600;
            $ssid = session_id();
            $this->db->rawQuery("DELETE from #_online where time<".(time()-$time));

            $onlinerec = $this->db->rawQuery("SELECT id,session_id from #_online order by id desc");
            $result['dangxem'] = count($onlinerec);

            $i = 0;
            while((@$onlinerec[$i]['session_id'] != $ssid) && $i++<$result['dangxem']);
            if($i<$result['dangxem'])
            {
                $sql = "UPDATE #_online set time='".time()."' where session_id='".$ssid."'";
                $this->db->rawQuery($sql);
                $result['daxem'] = $onlinerec[0]['id'];
            }
            else
            {
                $this->db->rawQuery("INSERT INTO #_online (session_id, time) values ('".$ssid."', '".time()."')");
                $result['daxem'] = $d->getLastInsertId();
                $result['dangxem']++;
            }
            return $result;
        }
        public function getRealIPAddress(){  
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
    }
?>