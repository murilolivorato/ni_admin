<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Administrador extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table    =  'administrador';
    protected $guarded  = ['id' , 'data_criacao' , 'data_alteracao'];
    protected $fillable = [
        'login',
        'nome_completo',
        'senha'
    ];

    public function Movimentacao()
    {
        return $this->hasMany(Movimentacao::class , 'gallery_id' );
    }
}
