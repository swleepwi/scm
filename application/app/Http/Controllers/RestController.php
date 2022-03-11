<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Customers;
use App\Order;
use App\OrderItem;
use App\Product;
use App\ProductBrand;
use App\ShippingAddress;
use Storage;
use Response;

class RestController extends Controller
{   
    
    public function __construct()
    {
    }
    
    public function brand($type = null)
    {
        $result = ProductBrand::All();
        $json = [
            'title' => 'Product Brand',
            'data' => [],
        ];
        
        foreach ($result as $key => $val) {
            $json['data'][$key] = [
                'id' => $val->id,
                'name' => $val->name,
            ];
        }

        if($type === "jsonl") {
            $fileName = "brand.jsonl";
            $headers = [
                'Content-type' => 'text/plain', 
                'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName)
            ];

            return Response::make($json, 200, $headers);
        } 

        return $json; 
    }

    public function product($type = null)
    {
        $result = Product::with('brand')->get();

        $json = [
            'title' => 'Product',
            'data' => [],
        ];
        
        foreach ($result as $key => $val) {
            $json['data'][$key] = [
                'id' => $val->id,
                'title' => $val->title,
                'subtitle' => $val->subtitle,
                'image' => $val->image,
                'upc' => $val->upc,
                'gtin14' => $val->gtin14,
                'brand' => [
                    'id' => $val->brand_id,
                    'name' => $val->brand->name
                ],
            ];
        }
        
        if($type === "jsonl") {
            $fileName = "product.jsonl";
            $headers = [
                'Content-type' => 'text/plain', 
                'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName)
            ];

            return Response::make($json, 200, $headers);
        } 

        return $json;
          
    }

    public function customer($type = null)
    {
        $result = Customers::All();
        $json = [
            'title' => 'Customer',
            'data' => [],
        ];
        
        foreach ($result as $key => $val) {
            $json['data'][$key] = [
                'id' => $val->id,
                'first_name' => $val->first_name,
                'last_name' => $val->last_name,
                'email' => $val->email,
                'phone' => $val->phone,
            ];
        }

        if($type === "jsonl") {
            $fileName = "customer.jsonl";
            $headers = [
                'Content-type' => 'text/plain', 
                'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName)
            ];

            return Response::make($json, 200, $headers);
        } 
        
        return $json; 
    }

    public function shipping_address($type = null)
    {
        $result = ShippingAddress::with('customer')->get();
        $json = [
            'title' => 'Shpping Address',
            'data' => [],
        ];
        
        foreach ($result as $key => $val) {
            $json['data'][$key] = [
                'customer_id' => $val->customer_id,
                'customer_name' => $val->customer->first_name." ".$val->customer->last_name,
                'street' => $val->street,
                'suburb' => $val->suburb,
                'state' => $val->state,
                'postcode' => $val->postcode,
            ];
        }
        if($type === "jsonl") {
            $fileName = "shipping_address.jsonl";
            $headers = [
                'Content-type' => 'text/plain', 
                'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName)
            ];

            return Response::make($json, 200, $headers);
        } 
        return $json;
    }

    
}
