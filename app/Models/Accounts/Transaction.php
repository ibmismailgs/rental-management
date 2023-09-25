<?php

namespace App\Models\Accounts;

use App\Models\RentInfo\FlatInfo;
use App\Models\RentInfo\RentInfo;
use App\Models\RentInfo\OwnerInfo;
use App\Models\RentInfo\TenantInfo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accounts\ExpenseCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public function owners(): BelongsTo
    {
        return $this->belongsTo(OwnerInfo::class, 'owner_info_id', 'id')->withTrashed();
    }

    public function flats(): BelongsTo
    {
        return $this->belongsTo(FlatInfo::class, 'flat_info_id', 'id')->withTrashed();
    }

    public function tenants(): BelongsTo
    {
        return $this->belongsTo(TenantInfo::class, 'tenant_info_id', 'id')->withTrashed();
    }

    public function rents(): BelongsTo
    {
        return $this->belongsTo(RentInfo::class, 'rent_info_id', 'id')->withTrashed();
    }

}
