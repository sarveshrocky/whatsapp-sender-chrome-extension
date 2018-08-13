
$(document).on('submit', '#form_open', function (e) {
  e.preventDefault()
  $('#form_errors_alert').addClass('hidden')
  chrome.tabs.query({ currentWindow: true }, function (tabs) {
    console.log(tabs)
  })

  // chrome.cookies.getAll({ url: INSTA_PATH + '/' }, function (cookies) {
  //   var cookieByName = cookies.reduce(function (obj, cookie) {
  //     obj[cookie['name']] = cookie['value']
  //     return obj
  //   }, {})
  //   var userId = cookieByName['ds_user_id']
  //   var formCode = $('#form_code').val()
  //   var q = $.post(CRM_PATH + '/chrome/confirm-extension', {
  //     user_id: userId,
  //     token: formCode
  //   })
  //   q.done(function (res) {
  //     if (res.status === 'ok') {
  //       chrome.storage.local.set({ icrm_extension_token: res.payload.token }, function () {
  //         var error = chrome.runtime.lastError
  //         if (error) {
  //           alert(error)
  //         } else {
  //           $('#form_add').addClass('hidden')
  //           $('#connect_success_alert').removeClass('hidden')
  //         }
  //       })
  //       $('#form_add').addClass('hidden')
  //
  //       $('#connect_success_alert').removeClass('hidden')
  //     } else {
  //       $('#form_errors_alert').html(res.error)
  //       $('#form_errors_alert').removeClass('hidden')
  //     }
  //   })
  //   q.fail(function (err) {
  //     console.error(err)
  //   })
  // })
})

// $('#genLink').attr('href', CRM_PATH + '/chrome/connect-extension')
