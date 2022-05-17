<?php

$recipients = 'info@zooterra.ru';

try {
    require './phpmailer/PHPMailerAutoload.php';

    preg_match_all("/([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)/", $recipients, $addresses, PREG_OFFSET_CAPTURE);

    if (!count($addresses[0])) {
        die('MF001');
    }

    if (preg_match('/^(127\.|192\.168\.)/', $_SERVER['REMOTE_ADDR'])) {
        die('MF002');
    }

    $template = file_get_contents('mailform_2.tpl');

    if (isset($_POST['form-type'])) {
        switch ($_POST['form-type']){
            case 'feedback':
                $subject = 'Из формы "Записаться на прием"';
                break;
            case 'subscribe':
                $subject = 'Subscribe request';
                break;
            case 'order':
                $subject = 'Order request';
                break;
            default:
                $subject = 'A message from your site visitor';
                break;
        }
    }else{
        die('MF004');
    }

    if (isset($_POST['phone'])) {
        $template = str_replace(
            array("<!-- #{FromState} -->", "<!-- #{Fromphone} -->"),
            array("Телефон:", $_POST['phone']),
            $template);
    }else{
        die('MF003');
    }
    if (isset($_POST['name'])) {
        $template = str_replace(
            array("<!-- #{FromState} -->", "<!-- #{Fromname} -->"),
            array("Имя:", $_POST['name']),
            $template);
    }else{
        die('MF003');
    }
    if (isset($_POST['pet'])) {
        $template = str_replace(
            array("<!-- #{FromState} -->", "<!-- #{Frompet} -->"),
            array("Питомец:", $_POST['pet']),
            $template);
    }else{
        die('MF003');
    }

    if (isset($_POST['type_service'])) {
        $template = str_replace(
            array("<!-- #{MessageState} -->", "<!-- #{type_service} -->"),
            array("Тип услуги:", $_POST['type_service']),
            $template);
    }

    preg_match("/(<!-- #{BeginInfo} -->)(.|\n)+(<!-- #{EndInfo} -->)/", $template, $tmp, PREG_OFFSET_CAPTURE);
    foreach ($_POST as $key => $value) {
        if ($key != "email" && $key != "message" && $key != "form-type" && $key != "g-recaptcha-response" && !empty($value)){
            $info = str_replace(
                array("<!-- #{BeginInfo} -->", "<!-- #{InfoState} -->", "<!-- #{InfoDescription} -->"),
                array("", ucfirst($key) . ':', $value),
                $tmp[0][0]);

            $template = str_replace("<!-- #{EndInfo} -->", $info, $template);
        }
    }

    $template = str_replace(
        array("<!-- #{Subject} -->", "<!-- #{SiteName} -->"),
        array($subject, $_SERVER['SERVER_NAME']),
        $template);

    $mail = new PHPMailer();
    $mail->From = 'web@zooterra.ru';

    # Attach file
    if (isset($_FILES['file']) &&
        $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $mail->AddAttachment($_FILES['file']['tmp_name'],
            $_FILES['file']['name']);
    }

    if (isset($_POST['name'])){
        $mail->FromName = $_POST['name'];
    }else{
        $mail->FromName = "Site Visitor";
    }

    foreach ($addresses[0] as $key => $value) {
        $mail->addAddress($value[0]);
    }

    $mail->CharSet = 'utf-8';
    $mail->Subject = "Информация о клиенте: ";
    $mail->MsgHTML($template);
    $mail->send();

    die('MF000');
} catch (phpmailerException $e) {
    die('MF254');
} catch (Exception $e) {
    die('MF255');
}