<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\ContactForm $model */

?>
<script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
<br />
<br />
<br />
<br />
<section id="contacts">
    <div class="container addr_row mb-4 d-flex flex-column flex-md-row">

        <div id="map" class='map'></div>
        <div class='addr_right ml-5 mb-3 mob-ml-0 mob-mt-15'>
            <strong>Наш адрес:</strong><br />
            ул. Шевченко 114, каб. 4<br />Бишкек, 720033<br />
            Тел.: <?= Html::a('(+996) 555 801166', 'tel:+996555801166') ?><br />
            Эл. почта: <?= Html::a('info@prosoft.kg', 'mailto:info@prosoft.kg') ?>
        </div>
    </div>
</section>
<script type="text/javascript">
    var map;

    DG.then(function() {
        map = DG.map('map', {
            center: [42.880933, 74.583257],
            zoom: 17
        });
        DG.marker([42.880933, 74.583257]).addTo(map).bindPopup('ОсОО Prosoft<br />ул. Шевченко 114');
    });
</script>