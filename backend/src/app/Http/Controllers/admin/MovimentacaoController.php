<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Admin\Movimentacao\LoadDisplay;

class MovimentacaoController extends Controller
{

    /**
     * @param Request $request
     * @return array
     */
    public function load_display(Request $request)
    {
        // COMECA  A DUSCA
        return LoadDisplay::loaud($request);
    }
}
