<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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

    public function checkRemoveMaterial()
    {
        $countNullable = 0;
        if ($this->pdf == null)
            $countNullable += 1;
        if ($this->doc == null)
            $countNullable += 1;
        if ($this->link_video == null)
            $countNullable += 1;

        if ($countNullable == 3) {
            $this->delete();
        }

        return false;
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (Material $material) {
            $material->user = auth()->user()->id;
            $material->save();
        });

        self::deleting(function (Material $material) {
            File::delete(storage_path('app/public' . $material->pdf));
            File::delete(storage_path('app/public' . $material->doc));
        });
    }
}
