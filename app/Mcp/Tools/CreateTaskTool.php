<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Attributes\Name;

#[Name('Create Task')]
#[Description('Permite crear una nueva tarea dentro de un proyecto GRP')]
class CreateTaskTool extends Tool
{
    /**
     * Define el esquema de entrada de la herramienta.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->required()->description('Titulo de la tarea'),
            'description' => $schema->string()->description('Descripcion detallada de la tarea'),
            'assigned_to' => $schema->string()->description('Usuario responsable de la tarea'),
            'status' => $schema->string()->description('Estado de la tarea'),
        ];
    }

    /**
     * Ejecuta la lógica de la herramienta.
     *
     * @param array $input Datos validados según el schema.
     * @return array Resultado de la operación.
     */
    public function handle(array $input): array
    {
        // Como MCP ya validó el input, podemos usarlo.
        $task = [
            'id' => uniqid(),
            'title' => $input['title'],
            'description' => $input['description'] ?? '',
            'assigned_to' => $input['assigned_to'] ?? null,
            'status' => $input['status'],
        ];

        // Persistir en bases de datos con Eloquent.
        // Task
    }
}
