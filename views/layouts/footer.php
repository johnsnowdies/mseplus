<?php
use app\models\Rates;

$rates = new Rates();
$data = $rates->getSystemRates();

?>

<div class="footer fixed">
    <div class="pull-right">
        <select id="footer-currency-selector" class="form-control m-b" name="account">
        <?php foreach($data as $key => $value):?>
            <option><?=$key?></option>
        <?php endforeach;?>

        </select>

    </div>

    <?php foreach($data as $key => $value):?>
    
    <div style="line-height: 40px; display: none;" class="footer-rate-pane" id="footer-<?=$key?>" >
        <?php foreach($value as $target => $rate):?>
            <span class="label label-<?= ($rate >= 1) ? 'primary': 'danger' ;?>"><?=$key?>/<?=$target?>:&nbsp;<?=number_format($rate,2)?></span>
        <?php endforeach;?>

    </div>
    <?php endforeach;?>
</div>
