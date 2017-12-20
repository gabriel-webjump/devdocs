<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Gene\BlueFoot\Setup\DataConverter\Renderer;

use Gene\BlueFoot\Setup\DataConverter\RendererInterface;
use Gene\BlueFoot\Setup\DataConverter\EavAttributeLoaderInterface;
use Gene\BlueFoot\Setup\DataConverter\StyleExtractorInterface;
use Gene\BlueFoot\Setup\DataConverter\StyleConverter;

/**
 * Render driver item to PageBuilder format
 */
class Divider implements RendererInterface
{
    /**
     * @var StyleExtractorInterface
     */
    private $styleExtractor;

    /**
     * @var EavAttributeLoaderInterface
     */
    private $eavAttributeLoader;

    /**
     * @var StyleConverter
     */
    private $styleConverter;

    public function __construct(
        StyleExtractorInterface $styleExtractor,
        EavAttributeLoaderInterface $eavAttributeLoader,
        StyleConverter $styleConverter
    ) {
        $this->styleExtractor = $styleExtractor;
        $this->eavAttributeLoader = $eavAttributeLoader;
        $this->styleConverter = $styleConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function render(array $itemData, array $additionalData = [])
    {
        $eavData = $this->eavAttributeLoader->hydrate($itemData);

        $rootElementAttributes = [
            'data-role' => 'divider',
            'class' => $eavData['css_classes'] ?? '',
            'style' => ''
        ];

        $style = $this->styleExtractor->extractStyle(
            $itemData['formData'],
            [
                'border-color' =>
                    isset($eavData['color']) ? $this->styleConverter->convertHexToRgb($eavData['color']) : '',
                'border-width' => isset($eavData['hr_height']) ? $eavData['hr_height'] : '',
                'width' => isset($eavData['hr_width']) ? $eavData['hr_width'] : ''
            ]
        );
        if ($style) {
            $rootElementAttributes['style'] .= $style;
        }

        $rootElementHtml = '<hr';
        foreach ($rootElementAttributes as $attributeName => $attributeValue) {
            $rootElementHtml .= $attributeValue ? " $attributeName=\"$attributeValue\"" : '';
        }
        $rootElementHtml .= '/>';

        return $rootElementHtml;
    }
}
