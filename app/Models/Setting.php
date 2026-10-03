<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    /**
     * Default settings dictionary grouped by tab/category.
     */
    public static function defaults(): array
    {
        return [
            // General
            'site_name' => ['value' => 'BlogHub', 'group' => 'general', 'type' => 'string'],
            'site_description' => ['value' => 'A modern and thoughtful platform for stories, ideas, and expert knowledge.', 'group' => 'general', 'type' => 'text'],
            'contact_email' => ['value' => 'contact@bloghub.com', 'group' => 'general', 'type' => 'string'],
            'site_logo' => ['value' => null, 'group' => 'general', 'type' => 'image'],
            'site_favicon' => ['value' => null, 'group' => 'general', 'type' => 'image'],

            // Appearance
            'theme_mode' => ['value' => 'light', 'group' => 'appearance', 'type' => 'string'],
            'primary_color' => ['value' => '#C8461F', 'group' => 'appearance', 'type' => 'string'],
            'site_tagline' => ['value' => 'Discover Thoughtful Stories & Expert Perspectives', 'group' => 'appearance', 'type' => 'string'],
            'posts_per_page' => ['value' => '9', 'group' => 'appearance', 'type' => 'integer'],

            // User & Access
            'enable_public_registration' => ['value' => '1', 'group' => 'access', 'type' => 'boolean'],
            'require_author_approval' => ['value' => '0', 'group' => 'access', 'type' => 'boolean'],
            'default_user_role' => ['value' => 'author', 'group' => 'access', 'type' => 'string'],

            // Comments
            'enable_comments' => ['value' => '1', 'group' => 'comments', 'type' => 'boolean'],
            'require_auth_comments' => ['value' => '1', 'group' => 'comments', 'type' => 'boolean'],
            'enable_comment_moderation' => ['value' => '0', 'group' => 'comments', 'type' => 'boolean'],
            'enable_comment_replies' => ['value' => '1', 'group' => 'comments', 'type' => 'boolean'],

            // Notifications
            'enable_email_notifications' => ['value' => '1', 'group' => 'notifications', 'type' => 'boolean'],
            'notify_on_new_comment' => ['value' => '1', 'group' => 'notifications', 'type' => 'boolean'],
            'notify_on_new_user' => ['value' => '1', 'group' => 'notifications', 'type' => 'boolean'],

            // Social Links
            'social_github' => ['value' => 'https://github.com/Aeeza-Hussain/BlogHub-Modern-Blogging-App', 'group' => 'social', 'type' => 'string'],
            'social_linkedin' => ['value' => 'https://linkedin.com', 'group' => 'social', 'type' => 'string'],
            'social_instagram' => ['value' => 'https://instagram.com', 'group' => 'social', 'type' => 'string'],
            'social_twitter' => ['value' => 'https://twitter.com', 'group' => 'social', 'type' => 'string'],
            'social_youtube' => ['value' => 'https://youtube.com', 'group' => 'social', 'type' => 'string'],
            'social_facebook' => ['value' => 'https://facebook.com', 'group' => 'social', 'type' => 'string'],
        ];
    }

    /**
     * Get a setting by key with fallback default.
     */
    public static function get(string $key, $default = null)
    {
        $all = static::getAllKeyValues();

        if (array_key_exists($key, $all)) {
            $val = $all[$key];
            if ($val === '1' || $val === 'true') {
                // Check if default is boolean
                $defaults = static::defaults();
                if (isset($defaults[$key]) && $defaults[$key]['type'] === 'boolean') {
                    return true;
                }
            } elseif ($val === '0' || $val === 'false') {
                $defaults = static::defaults();
                if (isset($defaults[$key]) && $defaults[$key]['type'] === 'boolean') {
                    return false;
                }
            }
            return $val;
        }

        $defaults = static::defaults();
        if (isset($defaults[$key])) {
            $def = $defaults[$key];
            if ($def['type'] === 'boolean') {
                return (bool) $def['value'];
            }
            return $def['value'];
        }

        return $default;
    }

    /**
     * Set / Update a setting value.
     */
    public static function set(string $key, $value, ?string $group = null, ?string $type = null): self
    {
        $defaults = static::defaults();
        $group = $group ?? ($defaults[$key]['group'] ?? 'general');
        $type = $type ?? ($defaults[$key]['type'] ?? 'string');

        if (is_bool($value)) {
            $value = $value ? '1' : '0';
        }

        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
            ]
        );

        Cache::forget('bloghub_settings_map');

        return $setting;
    }

    /**
     * Get all settings as key-value pairs (cached).
     */
    public static function getAllKeyValues(): array
    {
        return Cache::remember('bloghub_settings_map', 3600, function () {
            try {
                $dbSettings = static::pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                $dbSettings = [];
            }

            $result = [];
            foreach (static::defaults() as $k => $item) {
                $result[$k] = array_key_exists($k, $dbSettings) ? $dbSettings[$k] : $item['value'];
            }

            // Also include any custom keys saved in database
            foreach ($dbSettings as $k => $v) {
                if (!array_key_exists($k, $result)) {
                    $result[$k] = $v;
                }
            }

            return $result;
        });
    }

    /**
     * Seed or sync default values if missing.
     */
    public static function seedDefaults(): void
    {
        foreach (static::defaults() as $key => $data) {
            static::firstOrCreate(
                ['key' => $key],
                [
                    'value' => $data['value'],
                    'group' => $data['group'],
                    'type' => $data['type'],
                ]
            );
        }
        Cache::forget('bloghub_settings_map');
    }
}

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}
