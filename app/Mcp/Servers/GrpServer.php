<?php

namespace App\Mcp\Servers;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

use App\Mcp\Tools\CreateTaskTool;
use App\Mcp\Tools\UpdateTaskStatusTool;

#[Name('Grp Server')]
#[Version('1.0.0')]
#[Instructions('Este servidor gestiona recursos y proyectos del GRP, incluyendo tareas, usuarios y reportes')]
class GrpServer extends Server
{
    /**
     * Herramientas registradas en este servidor MCP.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Tool>>
     */
    protected array $tools = [
        CreateTaskTool::class,
        UpdateTaskStatusTool::class,
    ];

    /**
     * Recursos registrados en este servidor MCP
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Resource>>
     */
    protected array $resources = [
        //
    ];

    /**
     * Prompts registrados en este servidor MCP.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Prompt>>
     */
    protected array $prompts = [
        //
    ];
}
