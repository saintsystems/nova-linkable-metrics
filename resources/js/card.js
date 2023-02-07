import LinkableValueMetric from './components/LinkableValueMetric'
import LinkableTrendMetric from './components/LinkableTrendMetric'
import LinkablePartitionMetric from './components/LinkablePartitionMetric'

Nova.booting((app, store) => {
  app.component('linkable-value-metric', LinkableValueMetric)
  app.component('linkable-trend-metric', LinkableTrendMetric)
  app.component('linkable-partition-metric', LinkablePartitionMetric)
})
