<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function createSlug($name)
    {
        $slug = Str::slug($name);
        if (static::whereSlug($slug)->exists()) {
            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');

            if (is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }

            return "{$slug}-2";
        }

        return $slug;
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (Curso $curso) {
            $curso->slug = $curso->createSlug($curso->name);
            $curso->save();
        });

        self::deleting(function (Curso $curso) {
            $curso->matricula()->delete();
            $curso->material()->delete();
        });
    }
}
