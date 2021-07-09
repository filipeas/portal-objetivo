<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'pdf', 'doc', 'link_video', 'type_video',
    ];

    public function administrador()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (Material $material) {
            $material->user = auth()->user()->id;
            $material->save();
        });

        self::deleting(function (Material $material) {
            // 
        });
    }
}
