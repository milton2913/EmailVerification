<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class Setting extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory,Auditable;

    public $table = 'settings';


    const MAINTENANCE_MODE_SELECT = [
        'Yes' => 'Yes',
        'No'  => 'No',
    ];
    const ADMIN_APPROVAL_SELECT = [
        '1' => 'Yes',
        '0'  => 'No',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'favicon',
        'logo',
        'banner',
        'homepage_background',
    ];

    protected $fillable = [
        'site_title',
        'meta_description',
        'meta_keywords',
        'site_email',
        'site_phone_number',
        'address',
        'google_analytics',
        'maintenance_mode',
        'maintenance_mode_title',
        'maintenance_mode_content',
        'copyright',
        'summary',
        'about',
        'admin_approval',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getFaviconAttribute()
    {
        $file = $this->getMedia('favicon')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getLogoAttribute()
    {
        $file = $this->getMedia('logo')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }


    public function getBannerAttribute()
    {
        $file = $this->getMedia('banner')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getHomepageBackgroundAttribute()
    {
        $file = $this->getMedia('homepage_background')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public static function siteTitle(){
        $title = Setting::find(1);

    }

    public static function config(){
        $settings = Setting::find(1);
        return $settings;
    }
}
