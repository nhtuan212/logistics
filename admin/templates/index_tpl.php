<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h5 class="m-0 text-dark">Dashboard</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <a class="info-box" href="index.php?com=setting&act=man">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-cogs"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-sm">Cấu hình Website</span>
                            <span class="info-box-number">More info</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <a class="info-box" href="index.php?com=admin&act=info&type=admin">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users-cog"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-sm">Tài khoản</span>
                            <span class="info-box-number">More info</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <a class="info-box" href="index.php?com=admin&act=password&type=admin">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-key"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-sm">Đổi mật khẩu</span>
                            <span class="info-box-number">More info</span>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <a class="info-box" href="index.php?com=newsletter&act=man&type=contact">
                        <span class="info-box-icon bg-warning elevation-1"><i class="far fa-address-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-sm">Thư liên hệ</span>
                            <span class="info-box-number">More info</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php
        if(@$_GET['month']!='' && $_GET['year']!=''){
            $gt = $_GET['year'].'-'.$_GET['month'].'-'.'1';
            $date = strtotime($gt);
        }
        else $date = strtotime(date('y-m-d')); 

        $day = date('d', $date);
        $month = date('m', $date);
        $year = date('Y', $date);
        $daysInMonth = cal_days_in_month(0, $month, $year);
        $gth = array();

        for($i = 1; $i <= $daysInMonth; $i++){
            $month_tt = 0;
            $k = $i+1;
            $begin = strtotime($year.'-'.$month.'-'.$i);
            $start_day = $year.'-'.$month.'-'.$i.' 00:00:00';
            if($i==$daysInMonth){
                if($month==12){
                    $year_tt = $year+1;
                    $end = strtotime($year_tt.'-1-1');
                    $end_day = $year_tt.'-1-1'.' 00:00:00';
                } else {
                    $month_tt = $month+1;
                    $end = strtotime($year.'-'.$month_tt.'-1');
                    $end_day = $year.'-'.$month_tt.'-1'.' 00:00:00';
                }
            } else {
                $end = strtotime($year.'-'.$month.'-'.$k);
                $end_day = $year.'-'.$month_tt.'-1'.' 00:00:00';
            }
            $todayrc = $d->rawQueryOne("select COUNT(*) AS todayrecord FROM #_counter WHERE tm>=? and tm<?", array($begin, $end));
            $today_visitors = $todayrc['todayrecord']; 
            array_push($gth, $today_visitors);
        }
    ?>

    <section class="content mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Thống kê truy cập tháng <?=$month?>/<?=$year?></h5>
                        </div>
                        <div class="card-body">
                            <form action="index.php" method="get" name="form-thongke" accept-charset="utf-8">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control basic-single" name="month" id="month">
                                                <option>Chọn tháng</option>
                                                <?php for($i=1; $i <= 12 ;$i++) { ?>
                                                    <?php
                                                        if(@$_GET['year']) $selected = ($i==$_GET['month']) ? 'selected':'';
                                                        else $selected = ($i==date('m')) ? 'selected':'';
                                                    ?>
                                                    <option value="<?=$i?>" <?=$selected?>>Tháng <?=$i?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control basic-single" name="year" id="year">
                                                <option>Chọn năm</option>
                                                <?php for($i=2000;$i<=date('Y')+20;$i++) { ?>
                                                    <?php
                                                        if(@$_GET['year']) $selected = ($i==$_GET['year']) ? 'selected':'';
                                                        else $selected = ($i==date('Y')) ? 'selected':'';
                                                    ?>
                                                    <option value="<?=$i?>" <?=$selected?>>Năm <?=$i?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success"><i class="far fa-chart-bar mr-1"></i>Thống kê</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div id="apexMixedChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>