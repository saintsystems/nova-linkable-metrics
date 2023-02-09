import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'

import BaseLinkableValueMetric from './components/Base/BaseValueMetric'
import BaseLinkableTrendMetric from './components/Base/BaseTrendMetric'
import BaseLinkablePartitionMetric from './components/Base/BasePartitionMetric'

import LinkableValueMetric from './components/LinkableValueMetric'
import LinkableTrendMetric from './components/LinkableTrendMetric'
import LinkablePartitionMetric from './components/LinkablePartitionMetric'

Nova.booting((app, store) => {
  // const requireComponent = require.context(
  //   './components/Base',
  //   true,
  //   /[A-Z]\w+\.(vue)$/
  // )

  // requireComponent.keys().forEach(fileName => {
  //   const componentConfig = requireComponent(fileName)

  //   const componentName = upperFirst(
  //     camelCase(
  //       fileName
  //         .split('/')
  //         .pop()
  //         .replace(/\.\w+$/, '')
  //     )
  //   )

  //   //app.component(componentName, componentConfig.default || componentConfig)
  // })

  app.component('BaseLinkableValueMetric', BaseLinkableValueMetric)
  app.component('BaseLinkableTrendMetric', BaseLinkableTrendMetric)
  app.component('BaseLinkablePartitionMetric', BaseLinkablePartitionMetric)
  app.component('linkable-value-metric', LinkableValueMetric)
  app.component('linkable-trend-metric', LinkableTrendMetric)
  app.component('linkable-partition-metric', LinkablePartitionMetric)
})
