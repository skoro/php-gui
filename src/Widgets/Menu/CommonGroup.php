<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use ArrayIterator;
use IteratorAggregate;

/**
 * Makes a group of menu items.
 */
abstract class CommonGroup implements IteratorAggregate
{
    private int $id;

    // TODO: id generator ?
    private static int $idIterator = 0;

    /**
     * @var CommonItem[]
     */
    private array $items;

    /**
     * @param CommonItem[] The list of menu items.
     */
    public function __construct(array $items)
    {
        $this->id = static::generateId();
        $this->items = $items;
    }

    private static function generateId(): int
    {
        return ++static::$idIterator;
    }

    /**
     * Invoked when the group is attached to the menu.
     */
    abstract public function attach(Menu $menu): void;

    /**
     * @return CommonItem[]
     */
    public function items(): array
    {
        return $this->items;
    }

    // TODO: identificable interface
    public function id(): string
    {
        return 'menu-group-' . $this->id;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}