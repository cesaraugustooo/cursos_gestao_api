<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Avaliaco
 *
 * @property $id
 * @property $user_id
 * @property $curso_id
 * @property $nota
 * @property $comentario
 * @property $created_at
 * @property $updated_at
 *
 * @property Curso $curso
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Avaliaco extends Model
{
    public $table = 'avaliacoes';    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'curso_id', 'nota', 'comentario'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curso()
    {
        return $this->belongsTo(\App\Models\Curso::class, 'curso_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
