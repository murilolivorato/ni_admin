<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Funcionario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table    =  'funcionario';
    protected $guarded  = ['id' , 'data_criacao' , 'data_alteracao'];
    protected $fillable = [
        'administrador_id',
        'login',
        'u',
        'saldo_atual',
        'data_criacao',
        'data_alteracao'
    ];

    public function Movimentacao()
    {
        return $this->hasMany(Movimentacao::class , 'gallery_id' );
    }
}
