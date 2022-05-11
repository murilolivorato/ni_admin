<?php
namespace  App\Classes\Admin\Funcionario;
use App\Exceptions\StoreDataException;
use App\Models\Funcionario;
use Illuminate\Support\Facades\DB;

class ProcessDestroy
{
    /**
     * @var
     */
    protected $request;
    /**
     * @var array
     */
    protected $list_index = [];

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function process($request){
        try {
            return  (new static)->handle($request);
        }
        catch (StoreDataException $exeption) {
            throw $exeption->validationExeption();
        }
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function handle($request){
        return   $this->setRequest($request)
            ->destroy()
            ->result();
    }


    /**
     * @param $request
     * @return $this
     */
    private function setRequest($request){

        $this->request = $request;
        return $this;
    }

    /**
     * @return $this
     */
    private function destroy(){
        // POSSIBILIDADE DE EXCLUIR VÁRIOS USUÁRIOS DE UMA VEZ
        // START TRANSACTION
        DB::beginTransaction();

        foreach($this->request['delete'] as $deleteItem) {

            $funcionario = Funcionario::find($deleteItem['id']);
            // SE EXISTIR MOVIMENTAÇÃO , NÃO DEIXE APAGAR O FUNCIONÁRIO , PRIMEIRO TERÁ QUE APAGAR AS MOVIMENTAÇÕES
            if($funcionario->Movimentacao()->exists()) {
                throw_if(empty($this->list_index), new StoreDataException("Erro, Comunique o Suporte"));
            }

            if($funcionario->destroy() == true ){
                // INSERE NA LISTA QUAL FUNCIONÁRIO FOI DELETADO
                array_push($this->list_index , $deleteItem['index']);
            }
        }
        // SE NÃO FOI DELETADO NADA , ENVIE ERRO
        throw_if(empty($this->list_index), new StoreDataException("Erro, Comunique o Suporte"));

        // END TRANSACTION
        DB::commit();

        return $this;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function result(){
        // SUCESSO , RETORNA A LISTA COM OS FUNCIONÁRIOS DELETADOS
        return response()->json(['index'   => $this->list_index  ] , 200);
    }
}
