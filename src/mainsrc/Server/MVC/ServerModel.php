<?php

namespace App\Server\MVC;

use App\App\AbstractMVC\AbstractModel;

class ServerModel extends AbstractModel {
    public $guild_id;
    public $channel_ids;
    public $channel_names;
    public $role_ids;
    public $role_names;
}