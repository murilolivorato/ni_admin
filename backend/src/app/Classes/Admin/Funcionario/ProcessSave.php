<?php
namespace  App\Classes\Admin\Funcionario;

use App\Models\Administrador;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use App\Exceptions\StoreDataException;
class ProcessSave
{
    /**
     * @param Request $request
     * @param Funcionario $funcionario
     * @param  $adminstrador
     * @return \Illuminate\Http\JsonResponse
     */
    public static function process(Request $request , Funcionario $funcionario, $adminstrador ){
        try {
            return  (new static)->handle($request , $funcionario, $adminstrador);
        }
        catch (StoreDataException $exeption) {
            throw $exeption->validationExeption();
        }

    }

    /**
     * @param $request
     * @param $funcionario
     * @param $adminstrador
     * @return \Illuminate\Http\JsonResponse
     */
    private function handle($request , $funcionario, $adminstrador){
        return   $this->setRequest($request)
                      ->setAdministrador($adminstrador)
                      ->save($funcionario)
                      ->getResult();
    }

    // SET REQUEST

    /**
     * @param $request
     * @return $this
     */
    private function setRequest($request){
        $this->request = $request;
        return $this;
    }

    /**
     * @param $user
     * @return $this
     */
    private function setAdministrador($adminstrador){

        $this->administrador = $adminstrador != null ? Administrador::find($adminstrador->id) : null;
        return $this;
    }

    /**
     * @param $funcionario
     * @return $this
     */
    private function save($funcionario)
    {
        $funcionario->administrador_id = $this->administrador->id;
        $funcionario->login            = $this->request['login'];
        $funcionario->nome_completo    = $this->request['nome_completo'];
        $funcionario->saldo_atual      = $this->request['saldo_atual'];
        $funcionario->data_criacao     = $this->request['data_criacao'];
        $funcionario->data_alteraca    = $this->request['data_alteraca'];
        $funcionario->save();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResult(){
        // SUCESSO
        return response()->json(null , 200 );
    }
}
