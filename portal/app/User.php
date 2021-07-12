<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAlunos()
    {
        return $this->hasMany(User::class, 'user', 'id');
    }

    public function getMatriculasStudent()
    {
        return $this->hasMany(Matricula::class, 'student', 'id');
    }

    public function curso()
    {
        return $this->hasMany(Curso::class, 'user', 'id');
    }

    public function material()
    {
        return $this->hasMany(Material::class, 'user', 'id');
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (User $user) {
            $user->material()->delete();
            $user->curso()->delete();
            $user->getMatriculasStudent()->delete();
        });
    }
}
