<?php

namespace MyCompanyShop {

    class Product
    {
        public $name;
        public $price;
        public $manufacturer;
    }

    class Manufacturer
    {
        public $name;
        public $url;
    }

    class ProductMapper
    {
        public function toProduct($data)
        {
            $product = new Product();

            if (!empty($data['name'])) {
                $product->name = $data['name'];
            }
            if (!empty($data['price'])) {
                $product->price = $data['price'];
            }

            $product->manufacturer = new Manufacturer();
            if (!empty($data['manufacturer_name'])) {
                $product->manufacturer->name = $data['manufacturer_name'];
            }
            if (!empty($data['manufacturer_url'])) {
                $product->manufacturer->url = $data['manufacturer_url'];
            }
            return $product;
        }

        public function toArray($product)
        {
            return [
                "name" => $product->name,
                "price" => $product->price,
                "manufacturer_name" => $product->manufacturer->name,
                "manufacturer_url" => $product->manufacturer->url
            ];
        }
    }
}

namespace {

    use MyCompanyShop\Product;
    use MyCompanyShop\Manufacturer;
    use MyCompanyShop\ProductMapper;

    $data = [
        "name" => "test product",
        "price" => 50,
        "manufacturer_name" => "Widgets, Inc",
        "manufacturer_url" => "http://widgets.io"
    ];

    $mapper = new ProductMapper;

    $product = $mapper->toProduct($data);
    assert($product->name == "test product");
    assert($product instanceof Product);
    assert($product->price == 50);
    assert($product->manufacturer instanceof Manufacturer);
    assert($product->manufacturer->name == "Widgets, Inc");
    assert($product->manufacturer->url == "http://widgets.io");

    $mappedData = $mapper->toArray($product);
    assert($data === $mappedData);
}