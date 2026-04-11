<?php

use App\Mcp\Servers\GrpServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::oauthRoutes();

Mcp::local('Grp', GrpServer::class);
