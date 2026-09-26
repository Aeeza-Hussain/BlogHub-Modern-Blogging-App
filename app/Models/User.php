<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'contact',
        'gender',
        'dob',
        'image',
        'about',
        'niche',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'dob' => 'date',
            'user_type' => 'integer',
        ];
    }

    /**
     * The public author profile used as the byline on published articles.
     */
    public function author()
    {
        return $this->hasOne(Author::class);
    }

    /**
     * Get the public author profile, creating it on the fly when missing.
     * This is what articles.author_id must point to.
     */
    public function ensureAuthorProfile(): Author
    {
        if ($author = $this->author()->first()) {
            return $author;
        }

        $base = \Illuminate\Support\Str::slug($this->name) ?: 'author';
        $slug = $base;
        $i = 1;

        while (Author::where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }

        $author = Author::create([
            'user_id' => $this->id,
            'name' => $this->name,
            'slug' => $slug,
            'avatar' => $this->avatar_url,
            'tagline' => $this->niche ? $this->niche . ' Contributor' : 'BlogHub Author',
            'bio' => $this->about ?: 'Contributing author on BlogHub, sharing insights and perspectives.',
            'specialty' => $this->niche ?: 'General Topics',
            'followers_count' => 0,
            'following_count' => 0,
        ]);

        $this->setRelation('author', $author);

        return $author;
    }

    /**
     * Check if the user has administrator privileges.
     */
    public function isAdmin(): bool
    {
        return (int) $this->user_type === 1;
    }

    /**
     * Check if the user is allowed to publish articles.
     */
    public function canPublish(): bool
    {
        return in_array((int) $this->user_type, [1, 2], true);
    }

    /**
     * Get the avatar URL for the user.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=C8461F&color=ffffff&bold=true';
    }
}
