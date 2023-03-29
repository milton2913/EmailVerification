<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'purchases';
    public const IS_ACTIVE_SELECT = [
        '1' => 'Yes',
        '0' => 'No',
    ];
    protected $dates = [
        'purchase_date',
        'expiration_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'package_id',
        'purchase_date',
        'expiration_date',
        'email_verification_limit',
        'limit_used',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    public static function checkPackageLimit($total){
//        $packages =   Purchase::where('user_id',auth()->id())
//            ->where('expiration_date', '>', now()->format('Y-m-d H:i:s'))
//            ->whereRaw('email_verification_limit > limit_used')
//            ->where('is_active','1')
//            ->get();
        $packages = Purchase::where('user_id', auth()->id())
            ->where(function ($query) {
                $query->whereNull('expiration_date')
                    ->orWhere('expiration_date', '>', now()->format('Y-m-d H:i:s'));
            })
            ->whereRaw('email_verification_limit > limit_used')
            ->where('is_active', '1')
            ->get();
        $limit = 0;
        $used = $total;
        if (count($packages)>0){
            foreach ($packages as $package){
                $limit+=$package->email_verification_limit;
                $used+=$package->limit_used;
            }
            if ($limit>=$used){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function updatePackageLimit($total){
        $packages = Purchase::where('expiration_date', '>', now()->format('Y-m-d H:i:s'))
            ->whereRaw('email_verification_limit > limit_used')
            ->where('user_id',auth()->id())
            ->get();
        $data['limit_used']=$packages[0]->limit_used+$total;
        $packages[0]->update($data);
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function getPurchaseDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setPurchaseDateAttribute($value)
    {
        $this->attributes['purchase_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getExpirationDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setExpirationDateAttribute($value)
    {
        $this->attributes['expiration_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}
