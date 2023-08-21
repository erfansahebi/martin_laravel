<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CourierLocation
 *
 * @property int $id
 * @property float $lat
 * @property float $long
 * @property int $courier_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $Courier
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation whereCourierUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CourierLocation withoutTrashed()
 * @mixin \Eloquent
 */
class CourierLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lat',
        'long',
        'courier_user_id',
    ];

    protected $casts = [
        'lat'  => 'float',
        'long' => 'float',
    ];

    public function Courier (): BelongsTo
    {
        return $this->belongsTo( related: User::class, foreignKey: 'courier_user_id', ownerKey: 'id' );
    }
}
