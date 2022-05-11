<?php
namespace  App\Classes\Admin\Funcionario;
use App\Models\Funcionario;

class LoadDisplay
{
    /**
     * @var
     */
    protected $request;
    /**
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
     * @return \App\Classes\Admin\Movimentaca\LoadDisplay
     */
    private function setRequest($request){

        $this->request = $request;
        return $this;
    }


    // PROCESSING FORM

    /**
     * @return $this
     */
    public function processQuery()
    {

        $id                    = $this->request->input('id');
        $nome_completo         = $this->request->input('nome_completo');
        $saldo_atual_min       = $this->request->input('saldo_atual_min');
        $saldo_atual_max       = $this->request->input('saldo_atual_max');
        $data_criacao_min      = $this->request->input('data_criacao_min');
        $data_criacao_max      = $this->request->input('data_criacao_max');


        $this->result  = Funcionario::select([ 'id', 'administrador_id', 'login', 'nome_completo', 'saldo_atual', 'data_criacao', 'data_alteracao'  ])

            // WHEN HAS GOAL
            ->when($id, function ($query) use ($id) {
                return $query->where( 'id' , $id );
            })
            // QUANDO NOME
            ->when($nome_completo, function ($query) use ($nome_completo) {
                return $query->where('title', 'like' , '%' .  $nome_completo .'%'  );
            })
            // QUANDO NOME
            ->when(($saldo_atual_min && $saldo_atual_max), function ($query) use ($saldo_atual_min, $saldo_atual_max) {
                return $query->whereBetween('saldo_atual', [$saldo_atual_min, $saldo_atual_max]  );
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
    protected function getResult(){
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
