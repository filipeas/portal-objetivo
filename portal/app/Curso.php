<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Curso extends Model
{
    protected $table = 'cursos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'name', 'slug', 'cover', 'start_date', 'end_date',
    ];

    public function administrador()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function material()
    {
        return $this->hasMany(Material::class, 'curso', 'id');
    }

    public function matricula()
    {
        return $this->hasMany(Matricula::class, 'curso', 'id');
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Curso $curso) {
            $curso->matricula()->delete();
            foreach ($curso->material()->get() as $material) {
                $material->delete();
            }
            File::delete(storage_path('app/public/cover/' . $curso->cover));
        });
    }
}
