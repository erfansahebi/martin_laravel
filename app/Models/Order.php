<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Order
 *
 * @property string $id
 * @property float $origin_lat
 * @property float $origin_long
 * @property string $origin_address
 * @property string $provider_name
 * @property string $provider_phone_number
 * @property float $destination_lat
 * @property float $destination_long
 * @property string $destination_address
 * @property string $receiver_name
 * @property string $receiver_phone_number
 * @property int $corporate_id
 * @property int $courier_user_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Corporate $Corporate
 * @property-read \App\Models\User $Courier
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCorporateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCourierUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDestinationAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDestinationLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDestinationLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOriginAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOriginLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOriginLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProviderPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceiverName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceiverPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    const STATUS = [
        'canceled'                              => 0,
        'accepted_and_on_the_way_to_the_origin' => 1,
        'on_the_way_to_the_destination'         => 2,
        'done'                                  => 3,
        'pending'                               => 4,
    ];

    protected $fillable = [
        'origin_lat',
        'origin_long',
        'origin_address',
        'provider_name',
        'provider_phone_number',
        'destination_lat',
        'destination_long',
        'destination_address',
        'receiver_name',
        'receiver_phone_number',
        'corporate_id',
        'courier_user_id',
        'status',
    ];

    protected $casts = [
        'origin_lat'       => 'float',
        'origin_long'      => 'float',
        'destination_lat'  => 'float',
        'destination_long' => 'float',
    ];

    public function Corporate (): BelongsTo
    {
        return $this->belongsTo( related: Corporate::class, foreignKey: 'corporate_id', ownerKey: 'id' );
    }

    public function Courier (): BelongsTo
    {
        return $this->belongsTo( related: User::class, foreignKey: 'courier_user_id', ownerKey: 'id' );
    }

}
