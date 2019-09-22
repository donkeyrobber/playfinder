<?php
/**
 * Created by PhpStorm.
 * User: robm
 * Date: 21/09/2019
 * Time: 11:26
 */

namespace App\ResourceCollection;


use WoohooLabs\Yin\JsonApi\Schema\Pagination\PageBasedPaginationLinkProviderTrait;
use WoohooLabs\Yin\JsonApi\Schema\Pagination\PaginationLinkProviderInterface;
use IteratorAggregate;

class SlotCollection implements IteratorAggregate, PaginationLinkProviderInterface
{
    use PageBasedPaginationLinkProviderTrait;
    /**
     * @var \ArrayIterator
     */
    private $items;
    /**
     * @var int
     */
    private $total_items;
    /**
     * @var int
     */
    private $page;
    /**
     * @var int
     */
    private $size;
    public function __construct(array $items, int $total_items = 0, int $page = 0, int $size = 0)
    {
        $this->items = new \ArrayIterator($items);
        $this->total_items = $total_items;
        $this->page = $page;
        $this->size = $size;
    }
    public function getIterator(): iterable
    {
        return $this->items;
    }
    /**
     * @param mixed $item
     */
    public function addItem($item): void
    {
        $this->items->append($item);
    }
    public function setItems(\ArrayIterator $items): void
    {
        $this->items = $items;
    }
    public function getTotalItems(): int
    {
        return $this->total_items;
    }
    public function setTotalItems(int $total_items): void
    {
        $this->total_items = $total_items;
    }
    public function getPage(): int
    {
        return $this->page;
    }
    public function setPage(int $page): void
    {
        $this->page = $page;
    }
    public function getSize(): int
    {
        return $this->size;
    }
    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}