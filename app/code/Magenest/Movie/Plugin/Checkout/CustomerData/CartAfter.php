<?php

namespace Magenest\Movie\Plugin\Checkout\CustomerData;

use Magento\Checkout\CustomerData\Cart;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;

class CartAfter
{
    protected $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository

    )
    {
        $this->productRepository = $productRepository;
    }

    public function afterGetSectionData(Cart $subject, $result)
    {
        if (isset($result['items']) && is_array($result['items'])) {
            foreach ($result['items'] as &$item) {
                try {
                    // Dùng SKU thay vì ID, vì SKU là của sản phẩm con (simple)
                    $product = $this->productRepository->get($item['product_sku']);

                    if ($product->getTypeId() === 'simple') {
                        // Ghi đè ảnh cho sản phẩm simple trong giỏ hàng
                        $item['product_image']['src'] = $this->getImageUrl($product);

                        $colorValue = $product->getColor();
                        $attr = $product->getResource()->getAttribute('color');
                        if ($attr->usesSource()) {
                            $optionText = $attr->getSource()->getOptionText($colorValue);
                        }
                        // Lấy giá trị color (ID)
                        $item['product_name'] = "Test Configurable - " . $optionText;

                    }
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                    continue;
                }
            }
        }

        return $result;
    }


    protected function getImageUrl(Product $product)
    {
        $imageHelper = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Catalog\Helper\Image::class);
        return $imageHelper->init($product, 'cart_page_product_thumbnail')->getUrl();
    }


}