<?php if($type == 'watermark') { ?>
    <?php
        $tl = ($options['watermark']['position'] == 1 || !$options['watermark']['position']) ? 'checked' : '';
        $tc = ($options['watermark']['position'] == 2) ? 'checked' : '';
        $tr = ($options['watermark']['position'] == 3) ? 'checked' : '';
        $ml = ($options['watermark']['position'] == 4) ? 'checked' : '';
        $mc = ($options['watermark']['position'] == 5) ? 'checked' : '';
        $mr = ($options['watermark']['position'] == 6) ? 'checked' : '';
        $bc = ($options['watermark']['position'] == 7) ? 'checked' : '';
        $bl = ($options['watermark']['position'] == 8) ? 'checked' : '';
        $br = ($options['watermark']['position'] == 9) ? 'checked' : '';
        $watermark = CACHE.$config['photo_static'][$type]['photo_width'].'x'.$config['photo_static'][$type]['photo_height'].'x1/'.UPLOAD_PHOTO_L.@$item['photo'];
    ?>
    <div class="row">
        <div class="col-xl-8">
            <div class="form-group">
                <label>Vị trí đóng dấu:</label>
                <div class="watermark-position rounded">
                    <div class="row h-100">
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <label for="tl">
                                <input type="radio" name="data[options][watermark][position]" id="tl" value="1" <?=$tl?>>
                                <div class="img">
                                    <img class="rounded" onerror="src='<?=ASSETS?>images/noimage.png'" src="<?=($tl) ? $watermark : ''?>" alt="watermark-cover">
                                </div>
                            </label>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <label for="tc">
                                <input type="radio" name="data[options][watermark][position]" id="tc" value="2" <?=$tc?>>
                                <div class="img">
                                    <img class="rounded" onerror="src='<?=ASSETS?>images/noimage.png'" src="<?=($tc) ? $watermark : ''?>" alt="watermark-cover">
                                </div>
                            </label>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <label for="tr">
                                <input type="radio" name="data[options][watermark][position]" id="tr" value="3" <?=$tr?>>
                                <div class="img">
                                    <img class="rounded" onerror="src='<?=ASSETS?>images/noimage.png'" src="<?=($tr) ? $watermark : ''?>" alt="watermark-cover">
                                </div>
                            </label>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <label for="ml">
                                <input type="radio" name="data[options][watermark][position]" id="ml" value="4" <?=$ml?>>
                                <div class="img">
                                    <img class="rounded" onerror="src='<?=ASSETS?>images/noimage.png'" src="<?=($ml) ? $watermark : ''?>" alt="watermark-cover">
                                </div>
                            </label>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <label for="mc">
                                <input type="radio" name="data[options][watermark][position]" id="mc" value="5" <?=$mc?>>
                                <div class="img">
                                    <img class="rounded" onerror="src='<?=ASSETS?>images/noimage.png'" src="<?=($mc) ? $watermark : ''?>" alt="watermark-cover">
                                </div>
                            </label>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <label for="mr">
                                <input type="radio" name="data[options][watermark][position]" id="mr" value="6" <?=$mr?>>
                                <div class="img">
                                    <img class="rounded" onerror="src='<?=ASSETS?>images/noimage.png'" src="<?=($mr) ? $watermark : ''?>" alt="watermark-cover">
                                </div>
                            </label>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <label for="bl">
                                <input type="radio" name="data[options][watermark][position]" id="bl" value="7" <?=$bl?>>
                                <div class="img">
                                    <img class="rounded" onerror="src='<?=ASSETS?>images/noimage.png'" src="<?=($bl) ? $watermark : ''?>" alt="watermark-cover">
                                </div>
                            </label>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <label for="bc">
                                <input type="radio" name="data[options][watermark][position]" id="bc" value="8" <?=$bc?>>
                                <div class="img">
                                    <img class="rounded" onerror="src='<?=ASSETS?>images/noimage.png'" src="<?=($bc) ? $watermark : ''?>" alt="watermark-cover">
                                </div>
                            </label>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center">
                            <label for="br">
                                <input type="radio" name="data[options][watermark][position]" id="br" value="9" <?=$br?>>
                                <div class="img">
                                    <img class="rounded" onerror="src='<?=ASSETS?>images/noimage.png'" src="<?=($br) ? $watermark : ''?>" alt="watermark-cover">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="form-group">
                <label>Tỉ lệ:</label>
                <input type="text" class="form-control " name="data[options][watermark][per]"  placeholder="2" value="<?=$options['watermark']['per']?>">
            </div>
            <div class="form-group">
                <label>Tỉ lệ < 300px:</label>
                <input type="text" class="form-control " name="data[options][watermark][small_per]" placeholder="3" value="<?=$options['watermark']['small_per']?>">
            </div>
            <div class="form-group">
                <label>Kích thước tối đa:</label>
                <input type="text" class="form-control " name="data[options][watermark][max]" placeholder="600" value="<?=$options['watermark']['max']?>">
            </div>
            <div class="form-group">
                <label>Kích thước tối thiểu:</label>
                <input type="text" class="form-control " name="data[options][watermark][min]" placeholder="100" value="<?=$options['watermark']['min']?>">
            </div>
        </div>
    </div>
    <a class="btn btn-sm bg-gradient-success mb-3" href="javascript:previewWatermark();"><i class="fas fa-photo-video mr-2"></i>Preivew</a>
<?php } ?>