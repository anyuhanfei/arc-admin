<?php
namespace App\Tools\Sms;

interface SmsInterface{
    public function send_sms_code($phone, $code, $params = array());

    public function send_sms($phone, $type, $params = array());
}