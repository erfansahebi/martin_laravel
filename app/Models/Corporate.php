<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Corporate
 *
 * @property int $id
 * @property string $name
 * @property string $web_hook_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\CorporateFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate whereWebHookAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Corporate withoutTrashed()
 * @mixin \Eloquent
 */
class Corporate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'web_hook_address',
    ];

    public function orders (): HasMany
    {
        return $this->hasMany( related: Order::class, foreignKey: 'corporate_id', localKey: 'id' );
    }

    public function users (): BelongsToMany
    {
        return $this->belongsToMany( related: User::class, table: 'corporate_user', foreignPivotKey: 'corporate_id', relatedPivotKey: 'user_id', parentKey: 'id', relatedKey: 'id' )->wherePivotNull( 'deleted_at' );
    }
}
