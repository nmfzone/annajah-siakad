<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class VueFormSelect extends BaseComponent
{
    protected $baseSelector;

    public function __construct(string $baseSelector = '')
    {
        $this->baseSelector = $baseSelector;
    }

    public function selector(): string
    {
        return $this->baseSelector . '.v-select';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertVisible($this->selector());
    }

    public function elements(): array
    {
        return [
            '@search' => 'input.vs__search',
            '@values' => 'ul.vs__dropdown-menu',
            '@selectedValues' => '.vs__selected-options .vs__selected',
        ];
    }

    public function selectValue(Browser $browser, $value, $wait = 2000)
    {
        $browser->type('@search', $value)
            ->pause($wait)
            ->within('@values', function (Browser $browser) use ($value) {
                $element = $browser->findElementByText('li', $value);
                $browser->driver->getMouse()->click($element->getCoordinates());
                $browser->pause(1000);
            })
            ->assertSeeIn('@selectedValues', $value);
    }
}
