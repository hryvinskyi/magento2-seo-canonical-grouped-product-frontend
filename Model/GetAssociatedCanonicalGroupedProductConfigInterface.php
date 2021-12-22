<?php
/**
 * Copyright (c) 2021. All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoCanonicalGroupedProductFrontend\Model;

interface GetAssociatedCanonicalGroupedProductConfigInterface
{
    /**
     * @return bool
     */
    public function execute(): bool;
}
