import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'

// import BaseValueMetric from './components/Base/BaseValueMetric'
// import LinkableValueMetric from './components/LinkableValueMetric'
import LinkableValueMetric from './components/LinkableValueMetric'
// import LinkableTrendMetric from './components/LinkableTrendMetric'
// import LinkablePartitionMetric from './components/LinkablePartitionMetric'

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

  // app.component('BaseValueMetric', BaseValueMetric)
  app.component('linkable-value-metric', LinkableValueMetric)
  // app.component('linkable-trend-metric', LinkableTrendMetric)
  // app.component('linkable-partition-metric', LinkablePartitionMetric)
})
