<template>
  <div
    ref="vTailwindPickerRef"
    class="relative select-none"
    v-click-outside="onAway"
    :style="`--bg-tailwind-picker: ${theme.background};`">
    <slot></slot>
    <transition name="v-tailwind-picker">
      <div v-show="showPicker || inline">
        <div
          id="v-tailwind-picker"
          class="bg-transparent mt-3 z-10"
          :class="[
            { 'inline-mode': inline },
            inline ? 'static' : 'absolute bottom-0 inset-x-0',
            theme.currentColor,
          ]">
          <div
            class="w-88 h-auto max-w-xs transition-all duration-150 ease-linear rounded overflow-hidden border"
            :class="[
              theme.border,
              theme.text,
              inline ? 'shadow-xs' : 'shadow-md',
            ]"
            :style="{ backgroundColor: `var(--bg-tailwind-picker)` }">
            <div id="v-tailwind-picker-header">
              <div class="flex flex-row justify-center items-center px-2 py-1">
                <div class="flex items-center text-2xl xl:text-3xl">
                  {{ localSelectedDate.format('DD') }}
                </div>
                <div class="mx-1">
                  <div class="leading-none text-xxs">
                    {{ localSelectedDate.format('dddd') }}
                  </div>
                  <div class="leading-none text-xs">
                    {{ localSelectedDate.format('MMMM YYYY') }}
                  </div>
                </div>
              </div>
            </div>
            <div class="relative p-1">
              <div
                class="absolute inset-0"
                :class="theme.navigation.background"></div>
              <div class="flex justify-between items-center relative">
                <div class="flex-shrink-0 w-8">
                  <transition name="v-tailwind-picker-chevron-left">
                    <div
                      v-if="!enableMonth"
                      class="rounded-full overflow-hidden">
                      <div
                        class="transition duration-150 ease-out p-2"
                        :class="[
                          visiblePrev
                            ? 'cursor-pointer'
                            : 'cursor-not-allowed opacity-30',
                          theme.navigation.hover,
                        ]"
                        @click="onPrevious()">
                        <svg
                          class="h-4 w-auto"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 511.641 511.641"
                          fill="currentColor">
                          <path
                            d="M148.32 255.76L386.08 18c4.053-4.267 3.947-10.987-.213-15.04a10.763 10.763 0 00-14.827 0L125.707 248.293a10.623 10.623 0 000 15.04L371.04 508.667c4.267 4.053 10.987 3.947 15.04-.213a10.763 10.763 0 000-14.827L148.32 255.76z"
                          />
                        </svg>
                      </div>
                    </div>
                  </transition>
                </div>
                <div class="flex flex-1">
                  <div
                    class="flex-1 rounded overflow-hidden py-1 ml-2 mr-1 text-center cursor-pointer transition duration-150 ease-out"
                    :class="[
                      enableMonth ? theme.navigation.focus : '',
                      theme.navigation.hover,
                    ]"
                    @click="toggleMonth()">
                    {{ localSelectedDate.format('MMMM') }}
                  </div>
                  <div
                    class="flex-1 rounded overflow-hidden py-1 mr-2 ml-1 text-center cursor-pointer transition duration-150 ease-out"
                    :class="[
                      enableYear ? theme.navigation.focus : '',
                      theme.navigation.hover,
                    ]"
                    @click="toggleYear()">
                    {{ localSelectedDate.$y }}
                  </div>
                </div>

                <div class="flex-shrink-0 w-8">
                  <transition name="v-tailwind-picker-chevron-right">
                    <div
                      v-if="!enableMonth"
                      class="rounded-full overflow-hidden">
                      <div
                        class="transition duration-150 ease-out p-2"
                        :class="[
                          visibleNext
                            ? 'cursor-pointer'
                            : 'cursor-not-allowed opacity-30',
                          theme.navigation.hover,
                        ]"
                        @click="onNext()">
                        <svg
                          class="h-4 w-auto"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 511.949 511.949"
                          fill="currentColor">
                          <path
                            d="M386.235 248.308L140.902 2.975c-4.267-4.053-10.987-3.947-15.04.213a10.763 10.763 0 000 14.827l237.76 237.76-237.76 237.867c-4.267 4.053-4.373 10.88-.213 15.04 4.053 4.267 10.88 4.373 15.04.213l.213-.213 245.333-245.333a10.624 10.624 0 000-15.041z"
                          />
                        </svg>
                      </div>
                    </div>
                  </transition>
                </div>
              </div>
            </div>
            <div class="smooth-scrolling overflow-x-hidden overflow-y-auto">
              <transition name="v-tailwind-picker-body">
                <div v-if="!enableMonth && !enableYear" class="relative">
                  <div
                    class="flex flex-no-wrap py-2 border-b"
                    :class="theme.border">
                    <div
                      v-for="day in days"
                      :key="day.format('ddd')"
                      class="w-1/7 flex justify-center">
                      <div
                        class="leading-relaxed text-sm"
                        :class="[
                          day.day() === 0
                            ? theme.picker.holiday
                            : day.day() === 5
                              ? theme.picker.weekend
                              : '',
                        ]">
                        {{ day.format('ddd') }}
                      </div>
                    </div>
                  </div>

                  <div ref="currentPicker" class="flex flex-wrap relative">
                    <div
                      v-for="(date, i) in previousPicker"
                      :key="`${date.$D}${date.$M}${date.$y}-previous`"
                      class="w-1/7 flex justify-center my-2px cursor-not-allowed"
                      :class="[
                        i === previousPicker.length - 1 ? 'rounded-r-full' : '',
                        theme.navigation.background,
                      ]">
                      <div
                        class="h-8 w-8 flex justify-center items-center"
                        :data-tailwind-datepicker="date.$d">
                        <div
                          class="text-xs opacity-75"
                          :class="[
                            date.day() === 0
                              ? theme.picker.holiday
                              : date.day() === 5
                                ? theme.picker.weekend
                                : '',
                          ]">
                          {{ date.$D }}
                        </div>
                      </div>
                    </div>

                    <div
                      v-for="date in currentPicker"
                      :key="`${date.$D}${date.$M}${date.$y}-current`"
                      class="w-1/7 group flex justify-center items-center my-2px">
                      <div
                        class="relative"
                        :class="theme.picker.rounded">
                        <div
                          v-if="date.$events"
                          class="absolute top-0 right-0 h-2 w-2 z-2"
                          :class="theme.picker.event"
                          :style="{
                            backgroundColor: date.$events.color
                              ? date.$events.color
                              : '',
                          }"></div>
                        <div
                          class="relative h-8 w-8 flex justify-center items-center"
                          :class="[
                            theme.picker.rounded,
                            possibleDate(date)
                              ? 'cursor-pointer'
                              : 'cursor-not-allowed',
                          ]">
                          <div
                            v-if="possibleDate(date)"
                            class="absolute inset-0 transition duration-150 ease-in-out border border-dotted border-transparent"
                            :class="[
                              theme.picker.rounded,
                              possibleDate(date)
                                ? `hover:${theme.picker.selected.border}`
                                : '',
                              date.$D === localSelectedDate.$D
                                ? `${theme.picker.selected.background} shadow-xs`
                                : '',
                            ]"
                            @click="changePicker(date)"></div>
                          <div
                            class="flex justify-center items-center"
                            :data-tailwind-datepicker="date.$d">
                            <div
                              :class="[
                                (holidayDate(date) || date.day() === 0) &&
                                date.$D !== localSelectedDate.$D
                                  ? theme.picker.holiday
                                  : '',
                                date.day() === 5 && date.$D !== localSelectedDate.$D
                                  ? theme.picker.weekend
                                  : '',
                                {
                                  'z-10 text-white ':
                                    date.$D === localSelectedDate.$D && possibleDate(date),
                                },
                                {
                                  'opacity-50': !possibleDate(date),
                                },
                              ]">
                              <span>{{ date.$D }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div
                      v-for="date in nextPicker"
                      :key="`${date.$D}${date.$M}${date.$y}-next`"
                      class="w-1/7 flex justify-center my-2px cursor-not-allowed"
                      :class="[
                        date.$D === 1 ? 'rounded-l-full' : '',
                        theme.navigation.background,
                      ]">
                      <div
                        class="h-8 w-8 flex justify-center items-center"
                        :data-tailwind-datepicker="date.$d">
                        <div
                          class="text-xs opacity-75"
                          :class="[
                            date.day() === (startFromMonday ? 1 : 0)
                              ? theme.picker.holiday
                              : date.day() === (startFromMonday ? 6 : 5)
                              ? theme.picker.weekend
                              : '',
                          ]">
                          {{ date.$D }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </transition>
              <transition name="v-tailwind-picker-months">
                <div
                  v-if="enableMonth"
                  class="relative flex items-center smooth-scrolling overflow-y-auto overflow-x-hidden">
                  <div class="flex flex-wrap py-1">
                    <div
                      v-for="(month, i) in months"
                      :key="i"
                      class="w-1/3 flex justify-center items-center px-2">
                      <div
                        :class="[
                          i === localSelectedDate.$M
                            ? `${theme.picker.selected.border}`
                            : `${theme.border}`,
                          possibleDate(localSelectedDate.set('month', i))
                            ? `cursor-pointer ${theme.picker.selected.hover}`
                            : 'cursor-not-allowed opacity-50',
                        ]"
                        class="w-full flex justify-center items-center py-2 my-1 transition duration-150 ease-out rounded border"
                        @click="setMonth(i)">
                        <span class="font-medium">{{ month }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </transition>
              <transition name="v-tailwind-picker-years">
                <div
                  v-if="enableYear"
                  class="relative flex items-center h-full">
                  <div class="flex flex-wrap py-1 justify-center">
                    <div
                      v-for="(year, i) in years"
                      :key="i"
                      class="w-1/3 flex justify-center items-center px-2">
                      <div
                        :class="[
                          year === localSelectedDate.$y
                            ? `${theme.picker.selected.border}`
                            : `${theme.border}`,
                          possibleDate(localSelectedDate.set('year', year))
                            ? `cursor-pointer ${theme.picker.selected.hover}`
                            : 'cursor-not-allowed opacity-50',
                        ]"
                        class="w-full flex justify-center items-center py-2 my-1 transition duration-150 ease-out rounded border"
                        @click="setYear(year)">
                        <span class="font-medium">{{ year }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </transition>
            </div>
            <div
              v-if="currentPicker.filter((o) => o.$events !== undefined).length > 0"
              id="v-tailwind-picker-footer">
              <transition-group
                name="v-tailwind-picker-footer"
                tag="div"
                class="flex flex-wrap border-t p-1"
                :class="theme.event.border">
                <div
                  v-for="(event, i) in currentPicker.filter(
                    (o) => o.$events !== undefined,
                  )"
                  :key="`${i}-event`"
                  class="w-full flex flex-row space-x-1 mb-px">
                  <div class="inline-flex justify-end w-4">
                    <span
                      class="text-xs leading-none"
                      :class="theme.picker.holiday">
                      {{ dayjs(event.$events.date, formatDate).$D }}
                    </span>
                  </div>
                  <div class="flex flex-wrap">
                    <div class="w-full flex items-end">
                      <span class="text-xxs leading-none">
                        {{ event.$events.description }}
                      </span>
                    </div>
                  </div>
                </div>
              </transition-group>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import dayjs from 'dayjs'
import isToday from 'dayjs/plugin/isToday'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import isBetween from 'dayjs/plugin/isBetween'
import localizedFormat from 'dayjs/plugin/localizedFormat'
import advancedFormat from 'dayjs/plugin/advancedFormat'
import isSameOrBefore from 'dayjs/plugin/isSameOrBefore'
import isSameOrAfter from 'dayjs/plugin/isSameOrAfter'
dayjs.extend(isToday)
dayjs.extend(customParseFormat)
dayjs.extend(isBetween)
dayjs.extend(localizedFormat)
dayjs.extend(advancedFormat)
dayjs.extend(isSameOrBefore)
dayjs.extend(isSameOrAfter)

export default {
  name: 'VueTailwindPicker',
  props: {
    init: {
      type: Boolean,
      required: false,
      default: true,
    },
    selectedDate: {
      type: Object,
      required: false,
    },
    startDate: {
      type: String,
      required: false,
      default: undefined,
    },
    endDate: {
      type: String,
      required: false,
      default: undefined,
    },
    disableDate: {
      type: Array,
      required: false,
      default: () => [],
    },
    eventDate: {
      type: Array,
      required: false,
      default: () => [],
    },
    dateFormat: {
      type: String,
      required: false,
      default: 'YYYY-MM-DD',
    },
    inline: {
      type: Boolean,
      required: false,
      default: false,
    },
    tailwindPickerValue: {
      type: String,
      required: false,
      default: '',
    },
    dateRange: {
      type: Boolean,
      required: false,
      default: false,
    },
    autoClose: {
      type: Boolean,
      required: false,
      default: true,
    },
    startFromMonday: {
      type: Boolean,
      required: false,
      default: false,
    },
    theme: {
      type: Object,
      required: false,
      default: () => ({
        background: '#FFFFFF',
        text: 'text-gray-700',
        border: 'border-gray-200',
        currentColor: 'text-gray-200',
        navigation: {
          background: 'bg-gray-100',
          hover: 'hover:bg-gray-200',
          focus: 'bg-gray-200',
        },
        picker: {
          rounded: 'rounded-full',
          selected: {
            background: 'bg-red-500',
            border: 'border-red-500',
            hover: 'hover:border-red-500',
          },
          holiday: 'text-red-400',
          weekend: 'text-green-400',
          event: 'bg-indigo-500',
        },
        event: {
          border: 'border-gray-200',
        },
      }),
    },
  },
  data() {
    const startDatepicker = this.startDate
      ? dayjs(this.startDate, this.dateFormat)
      : dayjs().add(-100, 'year')
    const endDatepicker = this.endDate
      ? dayjs(this.endDate, this.dateFormat)
      : undefined
    const today = this.startDate
      ? dayjs(startDatepicker, this.dateFormat)
      : dayjs()
    const months = Array.from(Array(12), (v, i) => {
      return dayjs().month(i).format('MMMM')
    })
    return {
      localSelectedDate: false,
      startDatepicker,
      endDatepicker,
      today,
      visibleMonth: false,
      months,
      visibleYear: false,
      showPicker: false,
      programmableClick: false,
      startYear: null
    }
  },
  computed: {
    days() {
      const customWeekend = this.startFromMonday ? 1 : 0
      return Array.from(Array(7), (v, i) => {
        return dayjs()
          .day(i + customWeekend)
      })
    },
    years() {
      const display = []
      const currentYear = this.localSelectedDate.$y
      const startYear = currentYear - (11 - (currentYear % 12))
      if (!this.startYear || (currentYear < this.startYear) || (currentYear > this.startYear + 12)) {
        this.startYear = startYear
      }
      for (let i = 0; i < 12; i++) {
        display.push(this.startYear + i)
      }
      return display
    },
    previousPicker() {
      const customWeekend = this.startFromMonday ? 1 : 0
      const display = []
      const previous = this.localSelectedDate.date(0)
      const current = this.localSelectedDate.date(0)
      for (let i = 0; i <= current.day() - customWeekend; i++) {
        display.push(previous.subtract(i, 'day'))
      }
      return display.sort((a, b) => a.$d - b.$d)
    },
    currentPicker() {
      const customWeekend = this.startFromMonday ? 1 : 0
      const eventDate = this.eventDate.length > 0 ? this.eventDate : []
      return Array.from(
        Array(this.localSelectedDate.daysInMonth() - customWeekend),
        (v, i) => {
          const events = this.localSelectedDate.date(++i)
          events.$events = eventDate.find((o) => {
            return o.date === events.format(this.dateFormat)
          })
          return events
        },
      )
    },
    nextPicker() {
      const customWeekend = this.startFromMonday ? 1 : 0
      const display = []
      const previous = this.previousPicker.length
      const current = this.localSelectedDate.daysInMonth()
      for (let i = 1; i <= 42 - (previous + current) + customWeekend; i++) {
        display.push(this.localSelectedDate.date(i).add(1, 'month'))
      }
      return display
    },
    enableMonth() {
      return this.visibleMonth
    },
    enableYear() {
      return this.visibleYear
    },
    visiblePrev() {
      if (!this.dateRange) {
        const endOfMonth = this.localSelectedDate.subtract(1, 'month').endOf('month')
        const diff = this.startDatepicker.diff(endOfMonth, 'day')
        return diff < this.localSelectedDate.daysInMonth() - this.localSelectedDate.$D
      }
      return true
    },
    visibleNext() {
      if (!this.dateRange && this.endDate) {
        const startOfMonth = this.localSelectedDate.add(1, 'month').startOf('month')
        return this.endDatepicker.diff(startOfMonth, 'day') > 0
      }
      return true
    },
  },
  watch: {
    showPicker(prev, next) {
      if (prev) {
        this.visibleMonth = next
        this.visibleYear = next
      }
    },
  },
  beforeMount() {
    this.localSelectedDate = this.selectedDate
      ? (this.possibleDate(this.selectedDate)
        ? this.selectedDate
        : (this.endDate
          ? this.endDatepicker
          : (this.startDate
            ? this.startDatepicker
            : this.today)))
      : this.today
  },
  mounted() {
    if (this.init || this.selectedDate) {
      this.emit()
    }
  },
  methods: {
    dayjs,
    emit() {
      this.$emit('change', this.localSelectedDate)
    },
    changePicker(date) {
      this.localSelectedDate = date
      this.emit()
      this.showPicker = false
    },
    onPrevious() {
      if (this.visiblePrev) {
        let localSelectedDate
        if (this.enableYear) {
          localSelectedDate = this.localSelectedDate
            .set('year', this.localSelectedDate.$y - 12)
        } else {
          localSelectedDate = this.localSelectedDate
            .set('month', this.localSelectedDate.$M === 0 ? 11 : this.localSelectedDate.$M - 1)
            .set('year', this.localSelectedDate.$M === 0 ? this.localSelectedDate.$y - 1 : this.localSelectedDate.$y)
        }
        if (this.possibleDate(localSelectedDate)) {
          this.localSelectedDate = localSelectedDate
        }
        this.emit()
      }
    },
    onNext() {
      if (this.visibleNext) {
        let localSelectedDate
        if (this.enableYear) {
          localSelectedDate = this.localSelectedDate
            .set('year', this.localSelectedDate.$y + 12)
        } else {
          localSelectedDate = this.localSelectedDate
            .set('month', (this.localSelectedDate.$M + 1) % 12)
            .set('year', this.localSelectedDate.$M === 11 ? this.localSelectedDate.$y + 1 : this.localSelectedDate.$y)
        }
        if (this.possibleDate(localSelectedDate)) {
          this.localSelectedDate = localSelectedDate
        }
        this.emit()
      }
    },
    possibleStartDate(date) {
      return this.dateRange
        ? true
        : date.isSameOrAfter(this.startDatepicker, 'day')
    },
    possibleEndDate(date) {
      if (this.endDate) {
        return this.dateRange
          ? true
          : date.isSameOrBefore(this.endDatepicker, 'day')
      }
      return false
    },
    possibleDate(date) {
      if (this.endDate) {
        return this.possibleStartDate(date) && this.possibleEndDate(date)
      }
      return this.possibleStartDate(date)
    },
    holidayDate(date) {
      return !!(date.$events && date.$events.holiday)
    },
    toggleMonth() {
      this.visibleMonth = !this.visibleMonth
      if (this.visibleMonth) {
        this.visibleYear = false
      }
    },
    toggleYear() {
      this.visibleYear = !this.visibleYear
      if (this.visibleYear) {
        this.visibleMonth = false
      }
    },
    setMonth(month) {
      if (this.possibleDate(this.localSelectedDate.set('month', month))) {
        this.localSelectedDate = this.localSelectedDate.set('month', month)
        this.emit()
        this.toggleMonth()
      }
    },
    setYear(year) {
      if (this.possibleDate(this.localSelectedDate.set('year', year))) {
        this.localSelectedDate = this.localSelectedDate.set('year', year)
        this.emit()
        this.toggleYear()
      }
    },
    onAway() {
      if (!this.programmableClick) {
        this.showPicker = false
      }
      this.programmableClick = false
    },
    onFeedBack() {
      this.showPicker = true
    }
  }
}
</script>

<style lang="scss" scoped>
#v-tailwind-picker {
  top: 95%;
}
#v-tailwind-picker .w-1\/7 {
  width: 14.285714%;
}
#v-tailwind-picker .w-88 {
  width: 22rem;
}
#v-tailwind-picker .text-xxs {
  font-size: 0.6rem;
}
#v-tailwind-picker .my-2px {
  margin-top: 2px;
  margin-bottom: 2px;
}
#v-tailwind-picker:not(.inline-mode)::before {
  content: '';
  width: 14px;
  height: 14px;
  z-index: 10;
  top: -7px;
  left: 12px;
  border-radius: 2px;
  border-color: currentColor;
  position: absolute;
  display: block;
  background-color: var(--bg-tailwind-picker);
  border-left-width: 1px;
  border-top-width: 1px;
  transform: rotate(45deg);
}
#v-tailwind-picker .smooth-scrolling {
  height: 255px;
  max-height: 255px;
}
#v-tailwind-picker .smooth-scrolling::-webkit-scrollbar {
  width: 4px;
}
#v-tailwind-picker .smooth-scrolling ::-webkit-scrollbar-thumb {
  border-radius: 8px;
  background-color: rgba(0, 0, 0, 0.1);
}
.v-tailwind-picker-enter-active,
.v-tailwind-picker-leave-active {
  transition: all 0.1s;
}
.v-tailwind-picker-enter,
.v-tailwind-picker-leave-to {
  opacity: 0;
  transform: translateY(15px);
}
.v-tailwind-picker-body-enter-active,
.v-tailwind-picker-body-leave-active {
  transition: all 0.2s;
}
.v-tailwind-picker-body-enter,
.v-tailwind-picker-body-leave-to {
  opacity: 0;
  transform: translateY(-15px);
}
.v-tailwind-picker-months-enter-active,
.v-tailwind-picker-months-leave-active {
  transition: all 0.2s;
}
.v-tailwind-picker-months-enter,
.v-tailwind-picker-months-leave-to {
  opacity: 0;
  transform: translateY(-15px);
}
.v-tailwind-picker-years-enter-active,
.v-tailwind-picker-years-leave-active {
  transition: all 0.2s;
}
.v-tailwind-picker-years-enter,
.v-tailwind-picker-years-leave-to {
  opacity: 0;
  transform: translateY(-15px);
}
.v-tailwind-picker-footer-enter-active,
.v-tailwind-picker-footer-leave-active {
  transition: all 0.2s;
}
.v-tailwind-picker-footer-enter,
.v-tailwind-picker-footer-leave-to {
  opacity: 0;
  transform: translateY(-15px);
}
</style>
