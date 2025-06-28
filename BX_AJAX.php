<?
//подключаем пролог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//устанавливаем заголовок страницы
$APPLICATION->SetTitle("AJAX");

//подключение ядра и расширения ajax
   CJSCore::Init(array('ajax'));
   //идентификатор для ajax формы
   $sidAjax = 'testAjax';
   //проверяем отправлен ли ajax запрос с идентификатором
if(isset($_REQUEST['ajax_form']) && $_REQUEST['ajax_form'] == $sidAjax){
   $GLOBALS['APPLICATION']->RestartBuffer();// если это ajax запрос, сбрасываем буфер вывода
  //Преобразуем PHP массив в JSON объект для передачи данных
   echo CUtil::PhpToJSObject(array(
            'RESULT' => 'HELLO',
            'ERROR' => ''
   ));
   //завершение скрипта
   die();
}

?>
<div class="group">
   <div id="block"></div > <!-- Блок для отображения результатов AJAX-запроса -->
   <div id="process">wait ... </div > <!-- Индикатор загрузки -->
</div>
<script>
   //включаем расширение Ajax для запросов Bitrix
   window.BXDEBUG = true; 
   // функция отправляет AJAX-запрос на сервер
function DEMOLoad(){
   // скрываем блок с результатом и показываем индикатор загрузки
   BX.hide(BX("block"));
   BX.show(BX("process"));
   // загружаем объект и передаем в обработчик
   BX.ajax.loadJSON(
      '<?=$APPLICATION->GetCurPage()?>?ajax_form=<?=$sidAjax?>',
      DEMOResponse
   );
}
//выводим отладочную информацию в консоль
function DEMOResponse (data){
   BX.debug('AJAX-DEMOResponse ', data);
   //обновляем содержимое блока с результатом
   BX("block").innerHTML = data.RESULT;
   //показываем блок с результатом
   BX.show(BX("block"));
   //скрываем индикатор загрузки
   BX.hide(BX("process"));
   // устанавливаем обработчик события
   BX.onCustomEvent(
      BX(BX("block")),
      'DEMOUpdate'
   );
}
//добавляет обработчик события "DOM структура доступна для записи"
BX.ready(function(){
   /*
   BX.addCustomEvent(BX("block"), 'DEMOUpdate', function(){
      window.location.href = window.location.href;
   });
   */
  // скрываем блок с результатом и индикатор загрузки при загрузке страницы
   BX.hide(BX("block"));
   BX.hide(BX("process"));
   // передаем обработку клика на кнопку с классом 'css_ajax'
    BX.bindDelegate(
      document.body, 'click', {className: 'css_ajax' },
      function(e){
         // предотвращаем стандартное поведение ссылки
         if(!e)
            e = window.event;
         // Запускаем ajax запрос
         DEMOLoad();
         return BX.PreventDefault(e);
      }
   );
   
});

</script>
<div class="css_ajax">click Me</div>
<?
//подключаем эпилог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>