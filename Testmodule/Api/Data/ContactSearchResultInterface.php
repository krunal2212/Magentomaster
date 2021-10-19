<?php
namespace Magentomaster\Testmodule\Api\Data;

/**
 * @api
 */
interface ContactSearchResultInterface
{
    /**
     * Get Form list.
     *
     * @return \Magentomaster\Testmodule\Api\Data\ContactInterface[]
     */
    public function getItems();

    /**
     * Set Form list.
     *
     * @param \Magentomaster\Testmodule\Api\Data\ContactInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
