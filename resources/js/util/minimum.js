export default function (originalPromise, delay = 100) {
    return Promise.all([
      originalPromise,
      new Promise(resolve => {
        setTimeout(() => resolve(), delay)
      }),
    ]).then(result => result[0])
  }