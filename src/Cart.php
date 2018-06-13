<?php

namespace Bektas\Cart;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cart
{

    protected static $identifier = null;
    public static $groupName = 'default';

    /**
     * Saklama grubu için isim belirler.
     * @param type $groupName
     */
    public function setGroupName($groupName)
    {
        static::$groupName = $groupName;
        return $this;
    }

    /**
     * Sepeti eğer üye girişi varsa üyeye kaydeder, üye girişi yoksa oturuma kaydeder. (Sepet farklı bir cihazdan giriş yapılığında tekrar gelir.)
     * @param type $identifier
     * @return type
     */
    private function getIdentifier($identifier = null)
    {
        if ($identifier == '' || $identifier == null) {
            if (Auth::check()) {
                return static::$identifier = Auth::user()->email;
            } else {
                return static::$identifier = session()->getId();
            }
        }
    }

    /**
     * Sepet oluşturur.
     * @param type $identifier
     */
    public function setIdentifier($identifier)
    {
        if ($identifier != '') {
            static::$identifier = $identifier;
        }
    }

    /**
     * Sepete ürün ekler.
     * @param type $id
     * @param type $name
     * @param type $price
     * @param type $qty
     * @param type $options
     * @return CartEloquent
     */
    public function add($id, $name, $price, $qty, $options = [])
    {
        $rowId = $this->generateRowId($id, $options);
        if ($this->checkRowId($rowId)) {
            $row = $this->getRow($rowId);
            $this->updateQty($rowId, $row->qty + $qty);
            return $row;
        } else {
            $add = new CartEloquent();
            $add->id = $id;
            $add->rowId = $rowId;
            $add->groupName = static::$groupName;
            $add->identifier = $this->getIdentifier();
            $add->name = $name;
            $add->price = $price;
            $add->qty = $qty;
            $add->rowStatus = '1';
            $add->options = json_encode($options);
            if ($add->save()) {
                return $add;
            }
        }
        return false;
    }

    /**
     * Sepet içeriğini döndürür.
     * @return type
     */
    public function content()
    {
        if (CartEloquent::where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->count() > 0) {
            $data = CartEloquent::where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->get();
            $newData = [];
            foreach ($data as $val) {
                $item = $val;
                $item->options = json_decode($val->options);
                $item->subTotal = $val->qty * $val->price;
                $newData[] = $item;
            }
            return $newData;
        } else {
            return [];
        }
    }

    /**
     * Aktif Sepet içeriğini döndürür.
     * @return type
     */
    public function activeContent()
    {
        if (CartEloquent::where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->count() > 0) {
            $data = CartEloquent::where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->where('rowStatus', '1')->get();
            $newData = [];
            foreach ($data as $val) {
                $item = $val;
                $item->options = json_decode($val->options);
                $item->subTotal = number_format($val->qty * $val->price, 2, '.', '');
                $newData[] = $item;
            }
            return $newData;
        } else {
            return [];
        }
    }

    /**
     * Sepetten bir ürün getirir.
     * @param type $rowId
     * @return type
     */
    public function getRow($rowId)
    {
        $data = CartEloquent::where('rowId', $rowId)->where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->first();
        $data->options = json_decode($data->options);
        $data->subTotal = $data->qty * $data->price;
        return $data;
    }

    /**
     * Sepet ürün adedini günceller.
     * @param type $rowId
     * @param type $qty
     */
    public function updateQty($rowId, $qty)
    {
        if ($qty <= 0) {
            $result = CartEloquent::where('rowId', $rowId)->where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->delete();
        } else {
            $result = CartEloquent::where('rowId', $rowId)->where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->update(['qty' => $qty]);
        }
        return $result;
    }

    public function update($rowId, $data)
    {
        foreach ($data as $key => $val) {
            if ($key != 'options') {
                $update[$key] = $val;
            } else {
                $update['options'] = json_encode($val);
            }
        }
        return CartEloquent::where('rowId', $rowId)->where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->update($update);
    }

    public function count()
    {
        $total = CartEloquent::select(DB::raw('SUM(qty) AS total'))->where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->first()->total;
        if ($total == '')
            return 0;
        else
            return $total;
    }

    public function activeCount()
    {
        $total = CartEloquent::select(DB::raw('SUM(qty) AS total'))->where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->where('rowStatus', '1')->first()->total;
        if ($total == '') {
            return 0;
        } else {
            return $total;
        }
    }

    public function changeRowStatus($rowId, $status = '0')
    {
        return CartEloquent::where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->where('rowId', $rowId)->update(['rowStatus' => $status]);
    }

    /**
     * Sepetten ürün siler.
     * @param type $rowId
     * @return type
     */
    public function remove($rowId)
    {
        return CartEloquent::where('rowId', $rowId)->where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->delete();
    }

    /**
     * Sepetteki toplam fiyatı verir.
     * @return type
     */
    public function total()
    {
        $data = CartEloquent::where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->where('rowStatus', '1')->get(['qty', 'price']);
        $total = 0;
        foreach ($data as $val) {
            $total += $val->qty * $val->price;
        }
        return number_format($total, 2, '.', '');
    }

    /**
     * Sepeti komple siler.
     */
    public function destroy()
    {
        CartEloquent::where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->delete();
    }

    /**
     * AktifSepeti komple siler.
     */
    public function activeDestroy()
    {
        CartEloquent::where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->where('rowStatus', '1')->delete();
    }

    /**
     * Ürünün sepette olup olmadığını kontrol eder.
     * @param type $rowId
     * @return boolean
     */
    public function checkRowId($rowId)
    {
        if (CartEloquent::where('rowId', $rowId)->where('identifier', $this->getIdentifier())->where('groupName', static::$groupName)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sepette ürün için satır anahtarı üretir.
     * @param type $id
     * @param type $options
     * @return type
     */
    protected function generateRowId($id, $options)
    {
        ksort($options);
        return md5($id . serialize($options));
    }

    /**
     * Opsiyon değerini döndürür.
     * @param type $options
     * @param type $key
     * @return boolean
     */
    public function getOptVal($options, $key)
    {
        if (isset($options->$key)) {
            return $options->$key;
        } else {
            return false;
        }
    }
}
