// import something here

// leave the export, even if you don't use it
export default ({ app, router, Vue }) => {
  document.addEventListener('backbutton', function (evt) {
    if (window.location.hash !== '#/login') {
        window.history.back()
    } else {
        navigator.app.exitApp()
    }
  }, false)
}
