<?php declare(strict_types=1);

namespace Nicolasblancom\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Nicolasblancom\Blog\Model\ResourceModel\Post\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Nicolasblancom_Blog::post_delete';

    /** @var CollectionFactory */
    protected CollectionFactory $collectionFactory;

    /** @var Filter */
    protected Filter $filter;

    /**
     * MassDelete constructor.
     *
     * @param Context           $context
     * @param CollectionFactory $collectionFactory
     * @param Filter            $filter
     */
    public function __construct(
        Context           $context,
        CollectionFactory $collectionFactory,
        Filter            $filter
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->filter            = $filter;
    }

    public function execute(): Redirect
    {
        $collection = $this->collectionFactory->create();
        $items      = $this->filter->getCollection($collection);
        $itemsSize  = $items->getSize();

        foreach ($items as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $itemsSize));

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('*/*');
    }
}
