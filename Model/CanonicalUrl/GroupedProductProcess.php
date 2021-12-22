<?php
/**
 * Copyright (c) 2021. All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoCanonicalGroupedProductFrontend\Model\CanonicalUrl;

use Hryvinskyi\SeoCanonicalApi\Api\CanonicalUrl\ProcessInterface;
use Hryvinskyi\SeoCanonicalApi\Api\CheckIsProductEnabledInterface;
use Hryvinskyi\SeoCanonicalGroupedProductFrontend\Model\GetAssociatedCanonicalGroupedProductConfigInterface;
use Magento\GroupedProduct\Model\Product\Type\Grouped;

class GroupedProductProcess implements ProcessInterface
{
    /**
     * @var GetAssociatedCanonicalGroupedProductConfigInterface
     */
    private $config;

    /**
     * @var Grouped
     */
    private $productTypeGrouped;

    /**
     * @var CheckIsProductEnabledInterface
     */
    private $checkIsProductEnabled;

    /**
     * @param GetAssociatedCanonicalGroupedProductConfigInterface $config
     * @param Grouped $productTypeGrouped
     * @param CheckIsProductEnabledInterface $checkIsProductEnabled
     */
    public function __construct(
        GetAssociatedCanonicalGroupedProductConfigInterface $config,
        Grouped $productTypeGrouped,
        CheckIsProductEnabledInterface $checkIsProductEnabled
    ) {
        $this->config = $config;
        $this->productTypeGrouped = $productTypeGrouped;
        $this->checkIsProductEnabled = $checkIsProductEnabled;
    }

    /**
     * @inheritDoc
     */
    public function execute(array &$data): void
    {
        if (isset($data['associatedProductId']) === false && $this->config->execute() === true
            && ($parentGroupedProductIds = $this->productTypeGrouped->getParentIdsByChild($data['productId']))
            && isset($parentGroupedProductIds[0])
            && $this->checkIsProductEnabled->executeById($parentGroupedProductIds[0])
        ) {
            $data['associatedProductId'] = $parentGroupedProductIds[0];
        }
    }
}
