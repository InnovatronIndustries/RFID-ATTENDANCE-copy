<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Softdeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Getters
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getStatusAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return date('m/d/Y h:i:s A', strtotime($this->created_at));
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return date('m/d/Y h:i:s A', strtotime($this->updated_at));
    }

    /**
     * Setters
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = ucfirst($value);
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = ucfirst($value);
    }

    // remove leading zeros
    public function setMobileNoAttribute($value)
    {
        $this->attributes['mobile_no'] = $value !== null
            ? ltrim($value, "0")
            : null;
    }

    /**
     * Relationships
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }
}

