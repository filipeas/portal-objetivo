<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matriculas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'student', 'curso',
    ];

    public function administrador()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function aluno()
    {
        return $this->belongsTo(User::class, 'student', 'id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso', 'id');
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Matricula $matricula) {
            // 
        });
    }
}
