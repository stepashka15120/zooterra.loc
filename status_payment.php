<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/lib/autoload.php');
use YooKassa\Client;
use YooKassa\Model\NotificationEventType;

$client = new Client();
$client->setAuthToken('test_-4KxSAa2QFQYnjev3AEpc1rLojAAjNJAqV7iryM1bgk');

$response = $client->addWebhook([
    "event" => NotificationEventType::PAYMENT_SUCCEEDED,
    "url"   => "https://zooterra.ru/status_payment.php",
]);
////use YooKassa\Client;
////
////$client = new Client();
////$client->setAuth('862616', 'test_-4KxSAa2QFQYnjev3AEpc1rLojAAjNJAqV7iryM1bgk');
////// Получите данные из POST-запроса от ЮKassa
////use YooKassa\Client;
////use YooKassa\Model\Notification\NotificationSucceeded;
////use YooKassa\Model\Notification\NotificationWaitingForCapture;
////use YooKassa\Model\NotificationEventType;
//
//$client = new Client();
//$client->setAuthToken('<test_-4KxSAa2QFQYnjev3AEpc1rLojAAjNJAqV7iryM1bgk>');
////
////$response = $client->addWebhook([
////    "event" => NotificationEventType::PAYMENT_SUCCEEDED,
////    "url"   => "https://zooterra.ru/status_payment.php",
////]);
////
////    $source = file_get_contents('php://input');
////    $requestBody = json_decode($source, true);
////
////
////
////
////    try {
////      $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
////        ? new NotificationSucceeded($requestBody)
////        : new NotificationWaitingForCapture($requestBody);
////    } catch (Exception $e) {
////        // Обработка ошибок при неверных данных
////    }
////
////
////// Получите объект платежа
////
////
////    $payment = $notification->getObject();
////
//// принимаем ответ от юкассы
//
//$data = json_decode(file_get_contents("php://input"), true);

// Получите данные из POST-запроса от ЮKassa

//    $source = file_get_contents('php://input');
//    $requestBody = json_decode($source, true);
//
//    use YooKassa\Model\Notification\NotificationSucceeded;
//    use YooKassa\Model\Notification\NotificationWaitingForCapture;
//    use YooKassa\Model\NotificationEventType;
//
//    try {
//        $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
//            ? new NotificationSucceeded($requestBody)
//            : new NotificationWaitingForCapture($requestBody);
//    } catch (Exception $e) {
//        // Обработка ошибок при неверных данных
//    }
//
//    $payment = $notification->getObject();
//
   file_put_contents( "log/".date("Y-m-d_H-i-s").".log", json_encode($response));
