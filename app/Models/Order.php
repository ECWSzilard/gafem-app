<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $guarded = [];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            // Get current date components
            $now = Carbon::now();
            $year = $now->format('y'); // Last two digits of the year
            $month = $now->format('m'); // Month with leading zero
            $day = $now->format('d'); // Day with leading zero

            // Count orders created today
            $todayOrderCount = static::whereDate('created_at', $now->toDateString())->count();

            // Generate 3-digit sequence number (with leading zeros)
            $sequenceNumber = str_pad($todayOrderCount + 1, 3, '0', STR_PAD_LEFT);

            // Generate the ID in the format: YY-MM-DD-SSS
            $order->generated_id = "{$year}{$month}{$day}{$sequenceNumber}";
        });
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function serving()
    {
        return $this->hasOne(Serving::class, 'id', 'serving_id');
    }

    public function iceCreams()
    {
        return $this->belongsToMany(IceCream::class, 'order_ice_creams', 'order_id', 'ice_cream_id');
    }

    public function extraOptions()
    {
        return $this->belongsToMany(ExtraOption::class, 'order_extra_options', 'order_id', 'extra_option_id');
    }
}
