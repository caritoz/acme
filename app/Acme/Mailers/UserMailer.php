<?php
/**
 * Created by PhpStorm.
 * User: cgordillo
 * Date: 03/10/2014
 * Time: 11:49 AM
 */

namespace Acme\Mailers;

use Acme\Mailers\Mailer;

class UserMailer extends Mailer
{
    public function welcome(User $user)
    {
        $view = 'emails.welcome';
        $data = [];
        $subject = 'Welcome to Acme';

        return $this->sendTo($user, $subject, $view, $data);
    }
}