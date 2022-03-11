<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Customers;
use App\Order;
use App\OrderItem;
use App\Product;
use App\ProductBrand;
use App\ShippingAddress;

class Stream {

    public static function dataSync($fileUrl)
    {

        $filename = "order.jsonl"; //fixed Name to renaming the downloaded file
        $tempFile = getcwd()."/public/file/". $filename;
        $saveIt = copy($fileUrl, $tempFile);
        if($saveIt) {
            self::dataStore($tempFile);
        }

    }

    static function dataStore($filename) {
        $filePath = fopen($filename,"r");
        if ($filePath) {
            $x = 0;
            while (($line = fgets($filePath)) !== false)
            {
                $obj = json_decode($line);
                $items = null;                
                
                if(isset($obj->items[$x])) {
                    $items = $obj->items[$x];
                }

                self::setOrder($obj->order_id, $obj->order_date, $obj->customer, $items);
                $x++;
            }
            fclose($filePath);
        } 
    }
    
    
    static function setOrder($orderId, $orderDate, $customer, $items)
    {
        
        $data = Order::find($orderId);

        if(!$data) {
            $data = new Order;
            $data->id = $orderId;
            $data->customer_id = $customer->customer_id;
            $data->order_date = date('Y-m-d H:i:s', strtotime($orderDate));
            $data->add_date = date("Y-m-d H:i:s");
            $saved = $data->save();
        }
                
        self::setCustomer($customer, $customer->shipping_address);

        if(!empty($items)) {
            self::setBrand($items->product->brand);
            self::setProduct($items->product);
            self::setOrderItem($orderId, $items);
        }
        
    }

    static function setBrand($brand)
    {

        $data = ProductBrand::find($brand->id);    
       
        if(!$data) {
            $data = new ProductBrand;
            $data->id = $brand->id;            
            $data->add_date = date("Y-m-d H:i:s");            
        }   

        $data->name = $brand->name;   
        $saved = $data->save();  

    }

    static function setProduct($product)
    {

        $data = Product::find($product->product_id);    
        $category = implode(",", $product->category);

        if(!$data) {
            $data = new Product;
            $data->id = $product->product_id;            
            $data->add_date = date("Y-m-d H:i:s");            
        }        

        $data->brand_id = $product->brand->id;
        $data->title = $product->title;
        $data->subtitle = $product->subtitle;
        $data->image = $product->image;
        $data->thumbnail = $product->thumbnail;
        $data->category = $category;
        $data->url = $product->url;
        $data->upc = $product->upc;
        $data->gtin14 = $product->gtin14;
        $data->created_at = $product->created_at;
        $saved = $data->save();

    }

    static function setOrderItem($orderId, $items)
    {

        $data = OrderItem::where('order_id', $orderId)->where("product_id", $items->product->product_id)->get();    
        if(empty(count($data))) {
            $data = new OrderItem;
            $data->order_id = $orderId;
            $data->product_id = $items->product->product_id;
            $data->quantity = $items->quantity;
            $data->unit_price = $items->unit_price;
            $data->add_date = date("Y-m-d H:i:s");
            $saved = $data->save();
        }        

    }

    static function setCustomer($customer, $shippingAddress)
    {
        $data = Customers::find($customer->customer_id);

        if(!$data) {
            $data = new Customers;
            $data->id = $customer->customer_id;
            $data->add_date = date("Y-m-d H:i:s");
        }   
        
        $data->first_name = $customer->first_name;
        $data->last_name = $customer->last_name;
        $data->email = $customer->email;
        $data->phone = $customer->phone;
        $saved = $data->save();

        self::setShippingAddress($shippingAddress, $customer->customer_id);

    }

    static function setShippingAddress($shippingAddress, $customerId)
    {

        $data = ShippingAddress::find($customerId);
        if(!$data) {
            $data = new ShippingAddress;
            $data->customer_id = $customerId;
        }

        $data->street = $shippingAddress->street;
        $data->suburb = $shippingAddress->suburb;
        $data->state = $shippingAddress->state;
        $data->postcode = $shippingAddress->postcode;
        $saved = $data->save();

    }


    
}