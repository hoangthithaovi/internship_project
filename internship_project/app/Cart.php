<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $totaltong = 0;
    public function __construct($oldCart){
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totaltong = $oldCart->totaltong;
        } else {
            $this->items = null;
        }
    }
        //Them phan tu vao gio hang                             
    public function add($item, $id,$price) {
        $storedItem = ['qty' => 0,'id' => $id,'price' => $item->price,'folder'=>$item->getImage($id)->folder,'attached_file'=>$item->getImage($id)->attached_file,'item' => $item,'name_type_ticket'=>$item->name_type_ticket,'title_event'=>$item->events($id)->title_event];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty'] ++;
        $storedItem['title_event'] = $item->events($id)->title_event;
        $storedItem['folder'] = $item->getImage($id)->folder;
        $storedItem['attached_file'] = $item->getImage($id)->attached_file;
        $storedItem['name_type_ticket'] = $item->name_type_ticket;
        $storedItem['id'] = $id;
        $storedItem['price_update']= $item->price * $storedItem['qty'];
        $storedItem['price'] = $item->price;
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->price;
        $this->totaltong =  $this->totalPrice;
    }
    // Them loại vé vào giỏ hàng
    public function reduceByOne($id){                               
        $this->items[$id]['qty']--;                         
        $this->items[$id]['price'] = $this->items[$id]['price'];
        $this->items[$id]['price_update']-= $this->items[$id]['item']['price'];                         
        $this->totalQty--;                          
        $this->totalPrice -= $this->items[$id]['item']['price'];    
        $this->totaltong =  $this->totalPrice;                      
        if($this->items[$id]['qty']<=0){                            
            unset($this->items[$id]);                       
        }                           
    }
    public function removeItem($id){                                
        $this->totalQty -= $this->items[$id]['qty'];                            
        $this->totalPrice -= $this->items[$id]['qty'] * $this->items[$id]['price'];
        $this->totaltong = $this->totalPrice;                           
        unset($this->items[$id]);                           
    }   
    public function priceadd($item, $id, $price, $quantity) {
        $storedItem = ['qty' => 0,'id' => $id,'price' => $item->price,'folder'=>$item->getImage($id)->folder,'attached_file'=>$item->getImage($id)->attached_file,'item' => $item,'name_type_ticket'=>$item->name_type_ticket,'title_event'=>$item->events($id)->title_event];

        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']  += $quantity;
        $storedItem['title_event'] = $item->events($id)->title_event;
        $storedItem['folder'] = $item->getImage($id)->folder;
        $storedItem['attached_file'] = $item->getImage($id)->attached_file;
        $storedItem['name_type_ticket'] = $item->name_type_ticket;
        $storedItem['id'] = $id;
        $storedItem['price'] = $item->price;
        $this->items[$id] = $storedItem;
        $this->totalQty+= $quantity;
        $this->totalPrice += $price*$quantity;
        $this->totaltong =  $this->totalPrice;
    }       
}                                   

