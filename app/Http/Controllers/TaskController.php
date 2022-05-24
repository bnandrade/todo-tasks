<?php

namespace App\Http\Controllers;

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
     */
    public function tasks()
    {
        $tasks = auth('api')->user()->tasks;

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

}
