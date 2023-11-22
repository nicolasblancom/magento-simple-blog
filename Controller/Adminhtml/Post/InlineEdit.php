<?php

declare(strict_types=1);

namespace Nicolasblancom\Blog\Controller\Adminhtml\Post;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Nicolasblancom\Blog\Model\Post;
use Nicolasblancom\Blog\Model\PostFactory;
use Nicolasblancom\Blog\Model\ResourceModel\Post as PostResource;

class InlineEdit extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Nicolasblancom_Blog::post_save';

    /** @var JsonFactory */
    protected JsonFactory $jsonFactory;

    /** @var PostFactory */
    protected PostFactory $postFactory;

    /** @var PostResource */
    protected PostResource $postResource;

    /**
     * InlineEdit constructor.
     *
     * @param Context      $context
     * @param JsonFactory  $jsonFactory
     * @param PostFactory  $postFactory
     * @param PostResource $faqResource
     */
    public function __construct(
        Context      $context,
        JsonFactory  $jsonFactory,
        PostFactory  $postFactory,
        PostResource $postResource
    ) {
        parent::__construct($context);
        $this->jsonFactory  = $jsonFactory;
        $this->postFactory  = $postFactory;
        $this->postResource = $postResource;
    }

    public function execute(): Json
    {
        $json     = $this->jsonFactory->create();
        $messages = [];
        $error    = false;
        $isAjax   = $this->getRequest()->getParam('isAjax', false);
        $items    = $this->getRequest()->getParam('items', []);

        if (!$isAjax || !count($items)) {
            $messages[] = __('Please correct the data sent.');
            $error      = true;
        }

        if (!$error) {
            foreach ($items as $item) {
                $id = $item['id'];
                try {
                    /** @var Post $post */
                    $post = $this->postFactory->create();
                    $this->postResource->load($post, $id);
                    $post->setData(array_merge($post->getData(), $item));

                    $this->postResource->save($post);
                } catch (Exception $e) {
                    $messages[] = __("Something went wrong while saving item $id");
                    $error      = true;
                }
            }
        }

        return $json->setData([
                                  'messages' => $messages,
                                  'error'    => $error,
                              ]);
    }
}
