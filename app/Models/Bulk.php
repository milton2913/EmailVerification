<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bulk extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use Auditable;
    use HasFactory;
    public const TASK_TYPE = [
        'Dashboard' => 'Dashboard',
        'Task' => 'Task',
        'CSV' => 'CSV',
        'API' => 'API',
    ];

    public const IS_STATUS = [
        'Interval' => 'Interval',
        'Process' => 'Process',
        'Completed' => 'Completed',
        'Failed' => 'Failed'
    ];

    protected $fillable = [
        'name',
        'bulk_type',
        'user_id',
        'status',
        'total',
        'progress',
        'run_time',
        ];

    public function validEmails()
    {
        return $this->belongsToMany(ValidEmail::class);
    }
}
