<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\Exceptions\UninitializedVariableException;
use PhpGui\Options;
use PhpGui\TclTk\Variable;
use PhpGui\Widgets\Common\ValueInVariable;
use PhpGui\Widgets\TkWidget;
use SplObserver;

/**
 * Implementation of menu radio button item.
 *
 * @property string $label
 * @property Variable $variable
 * @property callable $command
 * @property mixed $value
 * @property int $underline
 */
class MenuRadioItem extends MenuItem implements ValueInVariable
{
    /**
     * @param callable|null $callback
     */
    public function __construct(string $label, string $value, $callback = null, array $options = [])
    {
        parent::__construct($label, $callback);
        $this->variable = $options['variable'] ?? null;
        $this->setValue($value);
    }

    public function type(): string
    {
        return 'radiobutton';
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new Options([
            'label' => null,
            'variable' => null,
            'command' => null,
            'value' => null,
            'underline' => null,
        ]);
    }

    /**
     * @param string $value
     */
    public function setValue($value): self
    {
        $this->value = $value;
        if ($this->variable) {
            $this->variable->set($value);
            $this->notify();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        $this->ensureVariable();
        return $this->variable->asString();
    }

    protected function ensureVariable(): void
    {
        if (! $this->variable) {
            throw new UninitializedVariableException();
        }
    }

    public function attach(SplObserver $observer)
    {
        parent::attach($observer);
        if ($observer instanceof TkWidget && ! $this->variable) {
            $this->variable = $observer->parent()->getEval()->registerVar($this->makeVariableName());
            $this->setValue($this->value);
        }
    }

    protected function makeVariableName(): string
    {
        return 'radio-item-' . $this->id();
    }
}