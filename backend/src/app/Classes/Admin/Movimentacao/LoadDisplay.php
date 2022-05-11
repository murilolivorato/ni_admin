<?php
namespace  App\Classes\Admin\Movimentacao;
use App\Models\Movimentacao;
class LoadDisplay
{
    /**
     * @var
     */
    protected $request;
    /**u
     * @var
     */
    protected $user;
    /**
     * @var
     */
    protected $queryResult;
    /**
     * @var int
     */
    protected $paginateNumber = 8;
    /**
     * @var null
     */
    protected $page = null;


    /**
     * @param $request
     * @return array
     */
    public static function load($request){

        return   (new static)->handle($request);
    }

    /**
     * @param $request
     * @return array
     */
    private function handle($request){
        return   $this->setRequest($request)
            ->processQuery()
            ->getResult();
    }

    /**
     * @param $request
     * @return $this
     */
    private function setRequest($request){

        $this->request = $request;
        return $this;
    }


    // PROCESSING FORM

    /**
     * @return $this
     */
    private function processQuery()
    {

        $id                    = $this->request->input('id');
        $valor_min             = $this->request->input('valor_min');
        $valor_max             = $this->request->input('valor_max');
        $observacao            = $this->request->input('observacao');
        $funcionario_id        = $this->request->input('funcionario_id');
        $administrador_id      = $this->request->input('administrador_id');
        $data_criacao_min      = $this->request->input('data_criacao_min');
        $data_criacao_max      = $this->request->input('data_criacao_max');


        $this->result  = Movimentacao::select([ 'id','tipo_movimentacao', 'valor', 'observacao', 'funcionario_id', 'administrador_id',  'data_criacao' ])

            // WHEN HAS GOAL
            ->when($id, function ($query) use ($id) {
                return $query->where( 'id' , $id );
            })

            // WHEN HAS GOAL
            ->when($id, function ($query) use ($id) {
                return $query->where( 'id' , $id );
            })
            // QUANDO NOME
            ->when(($valor_min && $valor_max) , function ($query) use ($valor_min, $valor_max) {
                return $query->whereDate($valor_min , '>' , $valor_max);
            })
            // QUANDO NOME
            ->when($observacao, function ($query) use ($observacao) {
                return $query->where('title', 'like' , '%' .  $observacao .'%'  );
            })
            // QUANDO NOME
            ->when($funcionario_id, function ($query) use ($funcionario_id) {
                return $query->where('funcionario_id', $funcionario_id  );
            })

            // ADMINISTRADOR ID
            ->when($administrador_id, function ($query) use ($administrador_id) {
                return $query->where('administrador_id', $administrador_id  );
            })

            // ADMINISTRADOR ID
            ->when(($data_criacao_min && $data_criacao_max), function ($query) use ($data_criacao_min, $data_criacao_max ) {
                return $query->whereDate($data_criacao_min , '>' , $data_criacao_max);
            })

            ->orderBy('data_criacao', 'DESC')
            ->paginate($this->paginateNumber , ['*'], 'page', $this->page );

        return $this;

    }

    /**
     * @return array
     */
    private function getResult(){
        return  [
            'pagination' => [
                'total'         => $this->result->total(),
                'per_page'      => $this->result->perPage(),
                'current_page'  => $this->result->currentPage(),
                'last_page'     => $this->result->lastPage(),
                'from'          => $this->result->firstItem(),
                'to'            => $this->result->lastItem()
            ],
            'data'             => $this->result->items()
        ];
    }
}
