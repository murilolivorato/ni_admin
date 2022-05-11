<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Admin\Funcionario\LoadDisplay;
use App\Classes\Admin\Funcionario\ProcessDestroy;
use App\Classes\Admin\Funcionario\ProcessSave;
use App\Http\Request\FuncionarioRequest;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{

    /**
     * @param Request $request
     * @return array
     */
    public function load_display(Request $request)
    {
        // COMECA  A DUSCA
        return LoadDisplay::load($request);
    }


    /**
     * @param FuncionarioRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FuncionarioRequest $request)
    {
        // FILIAL
        $userCustomer = new Funcionario($request->all());
        return  ProcessSave::process($request ,  $userCustomer , $this->user );
    }


    /**
     * @param FuncionarioRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(FuncionarioRequest $request , $id)
    {
        // FILIAL
        $userAdmin = Funcionario::find($id);

        if($userAdmin){
            return  ProcessSave::process($request ,  $userAdmin  , $this->user );
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        return  ProcessDestroy::process($request);
    }
}
