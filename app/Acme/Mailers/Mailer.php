<?php
/**
 * Created by PhpStorm.
 * User: cgordillo
 * Date: 03/10/2014
 * Time: 11:21 AM
 */
namespace Acme\Mailers;

abstract class Mailer
{
    public function sendTo($user, $subject, $view, $data = [])
    {
        \Mail::send($view, $data, function($message) use ($user, $subject){
            $message->to($user->email)
                    ->subject($subject);
        });
    }
}