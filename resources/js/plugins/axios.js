import axios from 'axios'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import store from '~/store'
import router from '~/router'

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.Authorization = `Bearer ${token}`
  }

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const status = error.response?.status

  if (status === 401 && store.getters['auth/check']) {
    Swal.fire({
      icon: 'warning',
      title: 'Session Expired!',
      text: 'Please log in again to continue.',
      reverseButtons: true,
      confirmButtonText: 'Ok',
      cancelButtonText: 'Cancel'
    }).then(() => {
      store.commit('auth/LOGOUT')

      router.push({ name: 'login' })
    })
  }

  if (status >= 500) {
    serverError(error.response)
  }

  return Promise.reject(error)
})

let serverErrorModalShown = false
async function serverError (response) {
  if (serverErrorModalShown) {
    return
  }

  if ((response.headers['content-type'] || '').includes('text/html')) {
    const iframe = document.createElement('iframe')

    if (response.data instanceof Blob) {
      iframe.srcdoc = await response.data.text()
    } else {
      iframe.srcdoc = response.data
    }

    Swal.fire({
      html: iframe.outerHTML,
      showConfirmButton: false,
      customClass: { container: 'server-error-modal' },
      didDestroy: () => { serverErrorModalShown = false },
      grow: 'fullscreen',
      padding: 0
    })

    serverErrorModalShown = true
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Something went wrong! Please try again.',
      reverseButtons: true,
      confirmButtonText: 'Ok',
      cancelButtonText: 'Cancel'
    })
  }
}
