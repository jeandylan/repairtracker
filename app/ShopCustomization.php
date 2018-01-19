<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopCustomization extends Model
{
    protected $connection = 'tenant'; ///unDurint Seeding
    protected $table='shop_customization'; //tbl Model refers to

    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
}
