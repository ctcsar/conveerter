<?php

$this->title = 'My Converter Application';
?>
<br>
<div>
    <div class="xxx-input-converter ">
        <input value="" data-input-converter="" data-name="RUB" data-cur-multiplier="1" type="tel" inputmode="decimal" class="xxx-input-converter__input rub xxx-full-width">
        <span class="xxx-input-converter__before-text"> RUB </span>
    </div>
    <br>
    <div class="xxx-input-converter ">
        <input value="" data-input-converter="" data-name="USD" data-cur-multiplier="1" type="tel" inputmode="decimal" class="xxx-input-converter__input usd xxx-full-width">
        <span class="xxx-input-converter__before-text"> USD </span>
    </div>
    <br>
    <div class="xxx-input-converter ">
        <input value="" data-input-converter="" data-name="EUR" data-cur-multiplier="1" type="tel" inputmode="decimal" class="xxx-input-converter__input eur xxx-full-width">
        <span class="xxx-input-converter__before-text"> EUR </span>
    </div>
    <br>
    <div class="xxx-input-converter ">
        <input value="" data-input-converter="" data-name="CNY" data-cur-multiplier="1" type="tel" inputmode="decimal" class="xxx-input-converter__input cny xxx-full-width">
        <span class="xxx-input-converter__before-text"> CNY </span>
    </div>
    <br>
    <div class="xxx-input-converter ">
        <input value="" data-input-converter="" data-name="BYN" data-cur-multiplier="1" type="tel" inputmode="decimal" class="xxx-input-converter__input byn xxx-full-width">
        <span class="xxx-input-converter__before-text"> BYN </span>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script>
    $('input').on('input', function (){
        let name = $(this).data('name')
        let count = $(this).val()
        getCurrency(name, count)
    })
    $(document).ready(function () {
        setTimeout(function () {
            getCurrency('RUB', 100)
        }, 200)
    })
    function getCurrency(name, count){
        $.ajax({
            method: "POST",
            url: "/site/convert-money",
            data: {name: name, count: count},
            success: function (data){
                data = JSON.parse(data)
                $('.rub').val(data.RUB.value)
                $('.usd').val(data.USD.value)
                $('.eur').val(data.EUR.value)
                $('.cny').val(data.CNY.value)
                $('.byn').val(data.BYN.value)
            }
        });
    }
</script>
