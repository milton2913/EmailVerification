<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Purchase;
class Package extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'packages';

    public const IS_ACTIVE_SELECT = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const IS_ACTIVATED_DURATION_SELECT = [
        '0' => 'No',
        '1' => 'Yes',
    ];

    protected $fillable = [
        'name',
        'price',
        'email_verification_limit',
        'is_active',
        'duration',
        'is_activated_duration',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }



    public function packagePurchases()
    {
        return $this->hasMany(Purchase::class, 'package_id', 'id');
    }

    public function benefits()
    {
        return $this->belongsToMany(Benefit::class);
    }
}
