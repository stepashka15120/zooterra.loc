<?php

    if($_POST["contact-first-name"] && $_POST["contact-pet"] && $_POST["type_service"] && $_POST["phone"]){
        $message = '
<html>
<head>
  <title>Формы с главной страницы</title>
</head>
<body>
  <p>Заполнена формы на главной странице: </p>
  
      <p>ФИО</p> - <p>'.$_POST["contact-first-name"].'</p>
      <p>Кто ваш питомец</p> - <p>'.$_POST["contact-pet"].'</p>
      <p>Какая услуга вам нужна</p> - <p>'.$_POST["type_service"].'</p>
      <p>Телефон</p> - <p>'.$_POST["phone"].'</p>
</body>
</html>';
        mail('web@zooterra.ru', 'Формы "ЗАПИСАТЬСЯ НА ПРИЕМ"', $message, $headers);
    }
?>