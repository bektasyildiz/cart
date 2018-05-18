<?php

namespace Bektas\Cart;

use Illuminate\Database\Eloquent\Model;

class CartEloquent extends Model
{

    protected $table;

    public function __construct()
    {
        $this->table = config('cart.table');
    }

}
