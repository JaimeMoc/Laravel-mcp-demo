<?php

use App\Mcp\Servers\GrpServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::local('Grp', GrpServer::class);
