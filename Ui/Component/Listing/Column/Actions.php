<?php

declare(strict_types=1);

namespace Nicolasblancom\Blog\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    /** @var UrlInterface */
    protected UrlInterface $urlBuilder;

    /**
     * Actions constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        array              $components = [],
        array              $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            if (!isset($item['id'])) {
                continue;
            }
            $id = $item['id'];

            $item[$this->getData('name')] = [
                'edit'   => [
                    'href'  => $this->urlBuilder->getUrl('blog/post/edit', [
                        'id' => $id,
                    ]),
                    'label' => __('Edit'),
                ],
                'delete' => [
                    'href'    => $this->urlBuilder->getUrl('blog/post/delete', [
                        'id' => $id,
                    ]),
                    'label'   => __('Delete'),
                    'confirm' => [
                        'title'   => __('Delete id: %1', $id),
                        'message' => __('Are you sure you want to delete post %1?', $id)
                    ]
                ],

            ];
        }

        return $dataSource;
    }
}
