<?php
namespace Dreamsunrise\Boatbooking\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Dreamsunrise\Boatbooking\Block\Adminhtml\Boat\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

class PostActions extends Column
{
    const POST_URL_PATH_EDIT = 'boatbooking/boat/edit';
    const POST_URL_PATH_DELETE = 'boatbooking/boat/delete';
    protected $actionUrlBuilder;
    protected $urlBuilder;
    private $editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::POST_URL_PATH_EDIT
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['enquiry_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['enquiry_id' => $item['enquiry_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::POST_URL_PATH_DELETE, ['enquiry_id' => $item['enquiry_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ${ $.$data.firstName } ${ $.$data.lastName }'),
                            'message' => __('Are you sure you wan\'t to delete a ${ $.$data.firstName } ${ $.$data.lastName } record?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
