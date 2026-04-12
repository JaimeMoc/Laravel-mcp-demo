<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Title;

use App\Models\Task;

#[Name('Create Task')]
#[title('Create Task')]
#[Description('Permite crear una nueva tarea dentro de un proyecto GRP')]
class CreateTaskTool extends Tool
{
    /**
     * Define el esquema de entrada de la herramienta.
     *
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->required()->description('Titulo de la tarea'),
            'description' => $schema->string()->description('Descripcion detallada de la tarea'),
            'assigned_to' => $schema->string()->description('Usuario responsable de la tarea'),
            'status' => $schema->string()
                ->required()
                ->enum(['pendiente', 'en_progreso', 'completada'])
                ->description('Estado de la tarea'),
        ];
    }

    /**
     * Define el esquema de salida de la herramienta.
     *
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
                'assigned_to' => $schema->string()->description('Usuario responsable de la tarea'),
                'status' => $schema->string()->description('Estado de la tarea'),
            ])->description('Datos de la tarea creada'),
        ];
    }
    /**
     * Ejecuta la lógica de la herramienta.
     */
    public function handle(array $input): array
    {
        try {
            // Crear tarea en base de datos
            $task = Task::create([
                'title' => $input['title'],
                'description' => $input['description'],
                'assigned_to' => $input['assigned_to'],
                'status' => $input['status'],
            ]);

            return [
                'success' => true,
                'message' => 'Tarea creada correctamente',
                'data' => [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'assigned_to' => $task->assigned_to,
                    'status' => $task->status,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al crear la tarea: ' . $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
