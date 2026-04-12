<?php

namespace App\Mcp\Tools;

use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Title;
use Laravel\Mcp\Server\Attributes\Description;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use App\Models\Task;

#[Name('Update Task Status')]
#[Title('Update Task Status')]
#[Description('Permite actualizar el estado de una tarea existente en el GRP.')]
class UpdateTaskStatusTool extends Tool
{
    /**
     * Define el esquema de entrada de la herramienta.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'id' => $schema->integer()->required()->description('ID de la tarea'),
            'status' => $schema->string()
                ->required()
                ->enum(['pendiente', 'en_progreso', 'completada'])
                ->description('Nuevo estado de la tarea'),
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
            'message' => $schema->string()->description('Mensaje informativo sobre el resultado'),
            'data' => $schema->object([
                'id' => $schema->integer()->description('ID de la tarea'),
                'status' => $schema->string()->description('Nuevo estado de la tarea'),
            ])->description('Objeto con los datos actualizados de la tarea'),
        ];
    }
    /**
     * Ejecuta la lógica de la herramienta
     *
     * @param array $input Datos válidos según el schema.
     * @return array Resultado de la operación.
     */
    public function handle(array $input): array
    {
        try {
            // Busca la tarea en la base de datos
            $task = Task::findOrFail($input['id']);

            // Actualizar el estado
            $task->status = $input['status'];
            $task->save();

            return [
                'success' => true,
                'message' => 'Se ha actualizado el estado de la tarea',
                'data' => [
                    'id' => $task->id,
                    'status' => $task->status,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'No se pudo actualizar el estado de la tarea',
                'data' => null,
            ];
        }
    }
}
