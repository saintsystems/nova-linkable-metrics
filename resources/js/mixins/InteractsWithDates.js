import { hourCycle } from 'laravel-nova-util'

export default {
  computed: {
    /**
     * Get the user's local timezone.
     *
     * @returns {string}
     */
    userTimezone() {
      return Nova.config('userTimezone') || Nova.config('timezone')
    },

    /**
     * Determine if the user is used to 12 hour time.
     *
     * @returns {boolean}
     */
    usesTwelveHourTime() {
      let locale = new Intl.DateTimeFormat().resolvedOptions().locale

      return hourCycle(locale) === 12
    },
  },
}
