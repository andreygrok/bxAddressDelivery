<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if ($_REQUEST['addr'] && strlen($_REQUEST['addr']) > 3 ) {
  // путь до класса кладра
  require($_SERVER["DOCUMENT_ROOT"] . "/ajax/kladr.php");
  $addr = $_REQUEST['addr'];
  $api = new Kladr\Api('51dfe5d42fb2b43e3300006e', '86a2c2a06f1b2451a87d05512cc2c3edfdf41969'); // тут ключи

  $query = new Kladr\Query();
  $query->ContentName = $addr;
  $query->OneString = TRUE;
  $query->Limit = 5;
  $arResult = $api->QueryToArray($query);
  ?>
  <ul class="places-kladr">
  <?
  if (!count($arResult)) {
    ?><li class="place-kladr-empty">Мы не смогли найти такой адрес :(</li><?
  } else {
    foreach ($arResult as $place) {?>
      <li class="place-kladr"><?=trim($place['fullName'])?></li>
    <?}
  }?>
  </ul>
<?}?>
