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
    function cartTotal($groupName = 'default')
    {
        return \Bektas\Cart\Facades\Cart::setGroupName($groupName)->total();
    }
}

if (!function_exists('cartCount')) {
    /*
     * sepet ürün adedini verir.
     */
    function cartCount($groupName = 'default')
    {
        return \Bektas\Cart\Facades\Cart::setGroupName($groupName)->activeCount();
    }
}

if (!function_exists('cartContent')) {
    /*
     * sepet ürün adedini verir.
     */
    function cartContent($groupName = 'default')
    {
        return \Bektas\Cart\Facades\Cart::setGroupName($groupName)->activeContent();
    }
}