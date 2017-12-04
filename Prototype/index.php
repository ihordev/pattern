<?php

namespace ShopingCartFramework {
    class Shop
    {
        protected $productPrototype;

        public function __construct(ProductInterface $productPrototype)
        {
            $this->productPrototype = $productPrototype;
        }

        public function listProducts(array $codes)
        {
            $output = [];
            foreach ($codes as $code) {
                $product = clone $this->productPrototype;
                $product->initialize($code);
                // @TODO create an actual $product, and initialize it
                $output[] = $product->getShopProductCode() . ' - ' . $product->getShopDescription();
            }
            return implode(PHP_EOL, $output);
        }
    }

    interface ProductInterface
    {
        public function initialize($code);

        public function getShopProductCode();

        public function getShopDescription();
    }
}

namespace MyCompanyShop {

    use ShopingCartFramework\ProductInterface;

    class MyShopProduct implements ProductInterface
    {
        private $code;
        private $mockWebService;

        public function __construct($mockWebService)
        {
            $this->mockWebService = $mockWebService;
        }

        public function initialize($code)
        {
            $this->code = $code;
        }

        public function getShopProductCode()
        {
            return $this->code;
        }

        public function getShopDescription()
        {
            return call_user_func($this->mockWebService, $this->code);
        }

    }

}

namespace {

    use ShopingCartFramework\Shop;
    use MyCompanyShop\MyShopProduct;

    $mockWebService = function ($code) {
        static $data = [
            'BumperSticker1' => 'Cool bumper sticker',
            'CoffeeTableBook5' => 'Coffee Table book',
        ];
        return $data[$code];
    };

    $shop = new Shop(new MyShopProduct($mockWebService));

    $productsToList = ['BumperSticker1', 'CoffeeTableBook5'];

    echo $shop->listProducts($productsToList); // simulation of Shopping Cart Listings Page
}