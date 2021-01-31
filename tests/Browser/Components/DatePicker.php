<?php

namespace Tests\Browser\Components;

use Exception;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;
use PHPUnit\Framework\Assert as PHPUnit;
use Tests\Concerns\Helper;

class DatePicker extends BaseComponent
{
    use Helper;

    protected $baseSelector;

    protected $browser;

    protected $invalidYear = "The choosen year in DatePicker [':selector:'] is not available.";

    protected $invalidMonth = "The choosen month in DatePicker [':selector:'] is not available.";

    protected $invalidDate = "The choosen date in DatePicker [':selector:'] is not available.";

    public function __construct(string $baseSelector)
    {
        $this->baseSelector = $baseSelector;
    }

    public function selector(): string
    {
        return 'body';
    }

    public function assert(Browser $browser): void
    {
        PHPUnit::assertTrue(
            $this->getDatePickerElement($browser)->isDisplayed(),
            $this->formatMessage("Datepicker for [':selector:'] is not visible.")
        );
    }

    public function elements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }

    public function selectDate(Browser $browser, int $year, int $month, int $day)
    {
        $pickerEl = $this->getDatePickerElement($browser);
        $this->pickerSelectYear($pickerEl, $year);
        $this->pause(500);
        $this->pickerSelectMonth($pickerEl, $month);
        $this->pause(500);
        $this->pickerSelectDate($pickerEl, $day);
        $this->pause(500);
    }

    protected function pickerSelectDate(RemoteWebElement $pickerEl, int $date)
    {
        $dateEl = $this->getDateElement($pickerEl, $date);

        PHPUnit::assertTrue(
            ! is_null($dateEl) && ! Str::contains(
                $dateEl->getAttribute('class'),
                'cursor-not-allowed'
            ),
            $this->formatMessage($this->invalidDate)
        );

        $dateEl->click();
    }

    protected function getDateElement(RemoteWebElement $pickerEl, int $date):  ?RemoteWebElement
    {
        $elements = $pickerEl->findElements(
            WebDriverBy::cssSelector('.picker-dates .picker-date')
        );

        foreach ($elements as $element) {
            if ($element->getText() == $date) {
                return $element;
            }
        }

        return null;
    }

    protected function pickerSelectMonth(RemoteWebElement $pickerEl, int $month)
    {
        $toggleMonthEl = $pickerEl
            ->findElement(
                WebDriverBy::cssSelector('.picker-toggle-month')
            );

        if ($this->convertMonthNameToNumber($toggleMonthEl->getText()) == $month) {
            return;
        }

        $toggleMonthEl->click();
        $this->pause(100);

        $monthEl = $this->getMonthElement($pickerEl, $month);

        PHPUnit::assertTrue(
            ! is_null($monthEl) && ! Str::contains(
                $monthEl->getAttribute('class'),
                'cursor-not-allowed'
            ),
            $this->formatMessage($this->invalidMonth)
        );

        $monthEl->click();
    }

    protected function getMonthElement(
        RemoteWebElement $pickerEl,
        int $month
    ): ?RemoteWebElement {
        $elements = $pickerEl->findElements(
            WebDriverBy::cssSelector('.picker-months .picker-month')
        );

        foreach ($elements as $element) {
            $text = $element->getText();
            if (! empty($text) && $this->convertMonthNameToNumber($text) == $month) {
                return $element;
            }
        }

        return null;
    }

    protected function convertMonthNameToNumber($name): int
    {
        return Carbon::parse(
            Carbon::translateTimeString('1 ' . $name, Carbon::getLocale(), 'en')
        )->month;
    }

    protected function pickerSelectYear(RemoteWebElement $pickerEl, int $year)
    {
        $toggleYearEl = $pickerEl
            ->findElement(
                WebDriverBy::cssSelector('.picker-toggle-year')
            );

        if ($toggleYearEl->getText() == $year) {
            return;
        }

        $toggleYearEl->click();
        $this->pause(100);

        $yearEl = null;
        while ($yearEl == null) {
            $years = $this->getPickerYears($pickerEl, true);

            if (count($years) == 0) {
                throw new Exception($this->formatMessage(
                    "Year elements in DatePicker [':selector:'] not available."
                ));
            }

            if (! in_array($year, $years)) {
                if ($years[0] > $year) {
                    $this->moveToPreviousOrNext($pickerEl);
                } elseif (last($years) < $year) {
                    $this->moveToPreviousOrNext($pickerEl, false);
                }
                $this->pause(100);
            } else {
                $yearEl = $this->getYearElement($pickerEl, $year);
            }
        }

        PHPUnit::assertFalse(
            Str::contains(
                $yearEl->getAttribute('class'),
                'cursor-not-allowed'
            ),
            $this->formatMessage($this->invalidYear)
        );

        $yearEl->click();
    }

    protected function moveToPreviousOrNext(RemoteWebElement $pickerEl, $toPrevious = true)
    {
        $buttonEl = $pickerEl
            ->findElement(
                WebDriverBy::cssSelector(
                    $toPrevious
                        ? '.picker-previous'
                        : '.picker-next'
                )
            );

        PHPUnit::assertFalse(
            Str::contains(
                $buttonEl->getAttribute('class'),
                'cursor-not-allowed'
            ),
            $this->formatMessage($this->invalidYear)
        );

        $buttonEl->click();
    }

    protected function getYearElement(RemoteWebElement $pickerEl, int $year): ?RemoteWebElement
    {
        $elements = $this->getPickerYears($pickerEl);

        foreach ($elements as $element) {
            if ($element->getText() == $year) {
                return $element;
            }
        }

        return null;
    }

    protected function getPickerYears(RemoteWebElement $pickerEl, $asNumber = false): array
    {
        $elements = $pickerEl->findElements(
            WebDriverBy::cssSelector('.picker-years .picker-year')
        );

        $years = [];
        foreach ($elements as $element) {
            $years[] = $asNumber ? (int) $element->getText() : $element;
        }

        if ($asNumber) {
            sort($years);
        }

        return $years;
    }

    protected function getDatePickerElement(Browser $browser): ?RemoteWebElement
    {
        $targetEl = $browser->resolver->findOrFail($this->baseSelector);
        $parentEl = $targetEl->findElement(WebDriverBy::xpath('./../..'));

        return $parentEl->findElement(
            WebDriverBy::id('v-tailwind-picker')
        );
    }

    protected function formatMessage($message): string
    {
        return str_replace(':selector:', $this->baseSelector, $message);
    }
}
