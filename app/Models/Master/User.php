<?php

namespace App\Models\Master;

use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-write mixed $password
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $email
 * @property string $mobile
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Master\Company[] $companies
 * @property-read \App\Models\Master\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\User whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\User whereUpdatedAt($value)
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'display_name', 'mobile'
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
     * Automatically creates hash for the user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function company()
    {
        return $this->hasOne('App\Models\Master\Company', 'user_id');
    }
    public function companies()
    {
        return $this->hasMany('App\Models\Master\Company', 'user_id');
    }
}
