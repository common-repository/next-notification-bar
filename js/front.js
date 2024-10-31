window.addEventListener('DOMContentLoaded', function () {
  const closeButton = document.querySelector('.js-nnb-close-button')
  const notificationBar = document.querySelector('.js-nnb-bar')
  const isPreview = notificationBar.dataset.preview === 'true'
  const isAdminUser = notificationBar.dataset.adminUser === 'true'

  const isShowBar = !JSON.parse(localStorage.getItem('nnb_hide'))
  if (isShowBar || isPreview) {
    notificationBar.style.display = 'block'
  }

  closeButton.addEventListener('click', function () {
    if (isPreview) {
      alert("Close button doesn't work on preview.")
    } else {
      notificationBar.remove()
      if (!isAdminUser) {
        localStorage.setItem('nnb_hide', JSON.stringify(true))
      }
    }
  })
})
