<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Events\UserSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prefixname',
        'firstname',
        'middlename',
        'lastname',
        'suffixname',
        'username',
        'email',
        'type',
        'password',
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($user) {
            event(new UserSaved($user));
        });
    }

    public function fileManager(): MorphOne
    {
        return $this->morphOne(FileManager::class, 'origin');
    }

    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    }

    public function getAvatarAttribute(): string
    {
        if ($this->filemanager) {
            return url($this->filemanager->file_link);
        }

        return "";
    }

    public function getFullNameAttribute(): string
    {
        $fullName = trim($this->firstname);

        if (!empty($this->middlename)) {
            $fullName .= ' ' . trim($this->middlename);
        }

        $fullName .= ' ' . trim($this->prefixname) . ' ' . trim($this->lastname);

        return $fullName;
    }

    public function getMiddleInitialAttribute(): string
    {
        return !empty($this->middlename) ? substr($this->middlename, 0, 1) . '.' : '';
    }
}
