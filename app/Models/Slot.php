<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $machine_id
 * @property int $product_id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereMachineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Slot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Slot extends Model
{
    protected $casts = [
        'price' => MoneyCast::class,
    ];

    public function product(): BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }
}
