<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateDescriptionRequest;
use App\Http\Requests\TaskUpdateStatusRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /*
     * Como usuário quero pode ver todas as minhas tarefas, por meio do meu login e senha.
     * Como usuário quero poder ver um relatório das minhas tarefas por status.
     */
    public function tasks()
    {
        $tasks = auth('api')->user()->tasks()->orderBy('status')->get();

        if($tasks->count() > 0){
            return response()->json($tasks);
        }

        return response()->json([
            'message' => 'Nenhuma Task cadastrada para este usuário',
            'user' => auth('api')->user()
        ], 201);

    }

    /*
     * Como usuário quero poder identificar quais tarefas ainda não concluí
     * Como usuário quero poder ver quais tarefas eu já concluí.
     *
     * $status => ['pendente', 'finalizada']
     */
    public function tasksStatus($status='pendente')
    {
        $tasks = auth('api')->user()->tasks()->where('status',$status)->get();

        if($tasks->count() > 0){
            return response()->json($tasks);
        }

        return response()->json([
            'message' => 'Nenhuma Task com status '.$status.' cadastrada para este usuário',
            'user' => auth('api')->user()
        ], 201);
    }

    /*
     * Como usuário quero poder marcar uma tarefa concluída e ter um feedback visual dessa mudança.
     */
    public function updateStatus(TaskUpdateStatusRequest $request, $id)
    {
        $data = $request->validated();

        $task = Task::query()->where('id',$id)->firstOrFail();
        $task->update($data);

        return response()->json([
            'message' => 'Status atualizado com sucesso',
            'task' => $task
        ], 200);
    }

    /*
     * Como usuário quero poder cadastrar novas tarefas.
     */
    public function create(TaskStoreRequest $request)
    {
        $data = $request->validated();

        $task = Task::query()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'user_id' => auth('api')->id()
        ]);

        return response()->json([
            'message' => 'Task criada com sucesso',
            'user' => $task
        ], 201);
    }

    /*
     * Como usuário quero poder alterar a descrição de uma tarefa.
     */
    public function updateDescription(TaskUpdateDescriptionRequest $request, $id)
    {
        $data = $request->validated();

        $task = Task::query()->where('id',$id)->firstOrFail();
        $task->update($data);

        return response()->json([
            'message' => 'Descrição atualizada com sucesso',
            'task' => $task
        ], 200);
    }

    /*
     * Como usuário quero poder excluir uma tarefa.
     */
    public function taskDelete($id)
    {
        $task = Task::where('user_id', auth('api')->id())->find($id);

        if(!$task){
            return response()->json(['error' => 'Task não encontrada!'], 401);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task excluída com sucesso',
        ], 201);

    }
}
