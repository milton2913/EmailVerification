<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValidEmail extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use Auditable;
    use HasFactory;

    public const IS_ACTIVE_SELECT = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    public const IS_COMPANY_SELECT = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    public const IS_STATUS = [
        '1' => 'Safe',
        '2' => 'InValid',
        '3' => 'CatchAll',
        '4' => 'Role',
        '5' => 'Disposable',
    ];
    public $table = 'valid_emails';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'email',
        'user_id',
        'is_valid_email',
        'where_to_check',
        'process_time',
        'email_score',
        'is_syntax_check',
        'is_disposable',
        'is_free_email',
        'is_domain',
        'is_mx_record',
        'is_smtp_valid',
        'is_username',
        'is_catch_all',
        'is_role',
        'created_by_id',
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function bulks()
    {
        return $this->belongsToMany(Bulk::class);
    }


}
