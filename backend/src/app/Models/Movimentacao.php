<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Movimentacao extends Model
{
    use HasFactory;

    protected $table    =  'movimentacao';
    protected $guarded  = ['id' , 'data_criacao'];
    protected $fillable = [
        'tipo_movimentacao',
        'valor',
        'observacao',
        'funcionario_id',
        'administrador_id'
    ];

    public function Funcionario()
    {
        return $this->belongsTo(Funcionario::class , 'gallery_id' );
    }
    public function Administrador()
    {
        return $this->belongsTo(Administrador::class , 'gallery_id' );
    }
}
