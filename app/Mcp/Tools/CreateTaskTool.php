<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Title;

#[Name('Create Task')]
#[title('Create Task')]
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
     * Define el esquema de salida de la herramienta.
     *
     * @return array<string, JsonSchema>
     */
    public function outputSchema(JsonSchema $schema): array
    {
        return [
            'success' => $schema->boolean()->description('Indica si la operación fue exitosa'),
            'message' => $schema->string()->description('mensaje informativo sobre el resultado'),
            'data' => $schema->object([
                'id' => $schema->integer()->description('ID de la tarea'),
                'title' => $schema->string()->description('Titulo de la tarea'),
                'description' => $schema->string()->description('Descripcion de la tarea'),
                'assigned_to' => $schema->string()->description('Usuario asignado a la tarea'),
                'status' => $schema->string()->description('Estado de la tarea'),
            ])->description('objeto con los datos de la tarea creada'),
        ];
    }
    /**
     * Ejecuta la lógica de la herramienta.
     *
     * @param array $input Datos validos según el schema.
     * @return array Resultado de la operación.
     */
    public function handle(array $input): array
    {
        // Como MCP ya validó el input, podemos usarlo directamente.
        $task = [
            'id' => uniqid(),
            'title' => $input['title'],
            'description' => $input['description'] ?? '',
            'assigned_to' => $input['assigned_to'] ?? null,
            'status' => $input['status'] ?? 'pendiente',
        ];

        // Aqui se incluye la persistencia de la base de datps con Eloquent
        // Task::create($task);

        return [
            'success' => true,
            'message' => 'La tarea se ha creado correctamente',
            'data' => $task,
        ];
    }
}
