<?php

namespace App\PasswordReset\MVC;

use App\App\AbstractMVC\AbstractModel;

class PasswordResetModel extends AbstractModel {
    public int $passwordid;
    public string $mail;
    public string $token;
    public string $code_expiry;
}