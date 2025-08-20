<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MateriaisAula
 *
 * @property $id
 * @property $aula_id
 * @property $file_path
 * @property $created_at
 * @property $updated_at
 *
 * @property Aula $aula
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class MateriaisAula extends Model
{
    public $table = 'materiais_aula';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['aula_id', 'file_path'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aula()
    {
        return $this->belongsTo(\App\Models\Aula::class, 'aula_id', 'id');
    }
    
}
