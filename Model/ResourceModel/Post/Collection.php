<?php declare(strict_types=1);

namespace Nicolasblancom\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Nicolasblancom\Blog\Model\Post;
use Nicolasblancom\Blog\Model\ResourceModel\Post as PostResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(Post::class, PostResourceModel::class);
    }
}
