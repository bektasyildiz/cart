<?php

if (!function_exists('cartOptVal')) {
    /*
     * Cart kütüphanesinde options içinden istenilen değeri verir.
     */
    function cartOptVal($options, $key)
    {
        return \Bektas\Cart\Facades\Cart::getOptVal($options, $key);
    }
}

if (!function_exists('cartTotal')) {
    /*
     * sepet fiyat toplamını verir.
     */
    function cartTotal()
    {
        return \Bektas\Cart\Facades\Cart::total();
    }
}

if (!function_exists('cartCount')) {
    /*
     * sepet ürün adedini verir.
     */
    function cartCount()
    {
        return \Bektas\Cart\Facades\Cart::activeCount();
    }
}