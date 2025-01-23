<template>
    <LoadingCard :loading="loading" class="px-6 py-4">
      <div class="h-6 flex items-center mb-4">
        <h3 class="mr-3 leading-tight text-sm font-bold">{{ title }}</h3>

        <HelpTextTooltip :text="helpText" :width="helpWidth" />

        <SelectControl
          v-if="ranges.length > 0"
          class="ml-auto w-[6rem] flex-shrink-0"
          size="xxs"
          :options="ranges"
          v-model="selectedRange"
          @change="handleChange"
          :aria-label="__('Select Ranges')"
        />
      </div>

      <div class="flex items-center mb-4 space-x-4">
        <div
          v-if="icon"
          class="rounded-lg bg-primary-500 text-white h-14 w-14 flex items-center justify-center"
        >
          <Icon :type="icon" width="24" height="24" />
        </div>

        <div>
          <component
            :is="copyable ? 'CopyButton' : 'p'"
            @click="handleCopyClick"
            class="flex items-center text-4xl"
            :rounded="false"
          >
            <Link :href="this.url" :title="title" class="link-default">
              <span v-tooltip="`${tooltipFormattedValue}`">
              {{ formattedValue }}
              </span>
            </Link>
            <span v-if="suffix" class="ml-2 text-sm font-bold">
              {{ formattedSuffix }}
            </span>
          </component>

          <div>
            <p class="flex items-center font-bold text-sm">
              <svg
                v-if="increaseOrDecreaseLabel == 'Decrease'"
                xmlns="http://www.w3.org/2000/svg"
                class="text-red-500 stroke-current mr-2"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"
                />
              </svg>
              <svg
                v-if="increaseOrDecreaseLabel == 'Increase'"
                class="text-green-500 stroke-current mr-2"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                />
              </svg>

              <span v-if="increaseOrDecrease != 0">
                <span v-if="growthPercentage !== 0">
                  {{ growthPercentage }}%
                  {{ __(increaseOrDecreaseLabel) }}
                </span>

                <span v-else>{{ __('No Increase') }}</span>
              </span>

              <span class="text-gray-400 font-semibold" v-else>
                <span v-if="previous == '0' && value != '0'">
                  {{ __('No Prior Data') }}
                </span>

                <span v-if="value == '0' && previous != '0' && !zeroResult">
                  {{ __('No Current Data') }}
                </span>

                <span v-if="value == '0' && previous == '0' && !zeroResult">
                  {{ __('No Data') }}
                </span>
              </span>
            </p>
          </div>
        </div>
      </div>
    </LoadingCard>
  </template>

  <script>
  import { increaseOrDecrease, singularOrPlural } from 'laravel-nova-util'
  import { CopiesToClipboard } from 'laravel-nova'

  export default {
    name: 'BaseLinkableValueMetric',

    mixins: [CopiesToClipboard],

    emits: ['selected'],

    props: {
      loading: { default: true },
      copyable: { default: false },
      title: {},
      helpText: {},
      helpWidth: {},
      icon: { type: String },
      maxWidth: {},
      previous: {},
      value: {},
      url: '',
      prefix: '',
      suffix: '',
      suffixInflection: { default: true },
      selectedRangeKey: [String, Number],
      ranges: { type: Array, default: () => [] },
      format: { type: String, default: '(0[.]00a)' },
      tooltipFormat: { type: String, default: '(0[.]00)' },
      zeroResult: { default: false },
    },

    data() {
      return {
        copied: false,
        selectedRange: this.selectedRangeKey,
      }
    },

    watch: {
      selectedRange(newValue) {
        this.$emit('selected', newValue)
      },

      selectedRangeKey(newRange, oldRange) {
        this.selectedRange = newRange
      },
    },

    methods: {
      handleCopyClick() {
        if (this.copyable) {
          this.copied = true
          this.copyValueToClipboard(this.tooltipFormattedValue)

          setTimeout(() => {
            this.copied = false
          }, 2000)
        }
      },

    },

    computed: {
      growthPercentage() {
        return Math.abs(this.increaseOrDecrease)
      },

      increaseOrDecrease() {
        if (this.previous == 0 || this.previous == null || this.value == 0)
          return 0

        return increaseOrDecrease(this.value, this.previous).toFixed(2)
      },

      increaseOrDecreaseLabel() {
        switch (Math.sign(this.increaseOrDecrease)) {
          case 1:
            return 'Increase'
          case 0:
            return 'Constant'
          case -1:
            return 'Decrease'
        }
      },

      sign() {
        switch (Math.sign(this.increaseOrDecrease)) {
          case 1:
            return '+'
          case 0:
            return ''
          case -1:
            return '-'
        }
      },

      isNullValue() {
        return this.value == null
      },

      formattedValue() {
        if (!this.isNullValue) {
          return (
            this.prefix + Nova.formatNumber(new String(this.value), this.format)
          )
        }

        return ''
      },

      tooltipFormattedValue() {
        if (!this.isNullValue) {
          return (
            this.prefix +
            Nova.formatNumber(new String(this.value), this.tooltipFormat)
          )
        }

        return ''
      },

      formattedSuffix() {
        if (this.suffixInflection === false) {
          return this.suffix
        }

        return singularOrPlural(this.value, this.suffix)
      },
    },
  }
  </script>
