<?php

namespace App\Logger\MVC;

use App\App\AbstractMVC\AbstractModel;

class LoggerModel extends AbstractModel {
    public int $id;
    public int $receiver;
    public int $sender;
    public $status;
    public $category;
    public $contentHeader;
    public $contentBody;
    public $contentForm;
    public $contentMail;
    public $relevance;
}