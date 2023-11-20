<?php

declare(strict_types=1);

namespace Nicolasblancom\Blog\Controller\Adminhtml\Post;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Nicolasblancom\Blog\Model\Post;
use Nicolasblancom\Blog\Model\PostFactory;
use Nicolasblancom\Blog\Model\ResourceModel\Post as PostResource;

class Delete extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Nicolasblancom_Blog::post_delete';

    /** @var PostResource */
    private PostResource $postResource;

    /** @var Post */
    private Post         $post;

    /** @var PostFactory */
    private PostFactory  $postFactory;

    /**
     * @param Context       $context
     * @param ResultFactory $resultFactory
     * @param Post          $post
     * @param PostFactory   $postFactory
     * @param PostResource  $postReource
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Post $post,
        PostFactory $postFactory,
        PostResource $postReource
    ) {
        parent::__construct($context);
        $this->resultFactory = $resultFactory;
        $this->postResource  = $postReource;
        $this->post = $post;
        $this->postFactory = $postFactory;
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        try {
            $id = $this->getRequest()->getParam('id');
            /** @var Post $post */
            $post = $this->postFactory->create();
            $this->postResource->load($post, $id);
            $postExists = $post->getId();
            $errorMessage = __('The record does not exist');
            $successMessage = __('The record has been deleted');

            if (!$postExists) {
                $this->messageManager->addErrorMessage($errorMessage);
            } else {
                $this->postResource->delete($post);
                $this->messageManager->addSuccessMessage($successMessage);
            }

            $this->postResource->delete($post);
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $redirect->setPath('*/*');
    }
}
