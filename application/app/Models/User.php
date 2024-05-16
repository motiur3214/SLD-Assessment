<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function fileManager(): MorphOne
    {
        return $this->morphOne(FileManager::class, 'origin');
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
        return trim($this->middlename);
    }
}
