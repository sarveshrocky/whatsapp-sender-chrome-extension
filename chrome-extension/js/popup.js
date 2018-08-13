window.addEventListener('DOMContentLoaded', function () {

  $(document).on('submit', '#form_open', function (e) {
    e.preventDefault()
    chrome.runtime.sendMessage({
      type: 'CREATE_WA_TAB',
      phone: $('#phone').val(),
      text: $('#text').val()
    }, function (response) {})
  })

  // var requirements = {
  //   token: false,
  //   authorized: false
  // }
  //
  // // 1. Check token
  // chrome.storage.local.get('icrm_extension_token', function (storage) {
  //   if ('icrm_extension_token' in storage) {
  //     $('#chext').html(storage['icrm_extension_token'])
  //     $('#icrm_ext_not_connected').hide()
  //     requirements['token'] = true
  //   } else {
  //     $('#chext').html('')
  //     $('#icrm_ext_not_connected').show()
  //     requirements['token'] = false
  //   }
  //
  //   // 2. Check authorization
  //   chrome.runtime.sendMessage({ type: 'IS_AUTHORIZED_REQUEST' }, function (response) {
  //     var error = chrome.runtime.lastError
  //     if (error) {
  //       alert(JSON.stringify(error))
  //     }
  //     if (('userId' in response) && (response['userId'] !== undefined)) {
  //       $('#icrm_ext_not_authorized').hide()
  //       requirements['authorized'] = true
  //     } else {
  //       $('#icrm_ext_not_authorized').show()
  //       requirements['authorized'] = false
  //     }
  //
  //     // 3. Update badge
  //     if (!requirements['authorized'] || !requirements['token']) {
  //       $('#icrm_problems_detected_label').show()
  //       chrome.browserAction.setBadgeBackgroundColor({ color: '#e33e14' })
  //       chrome.browserAction.setBadgeText({ text: '!' })
  //     } else {
  //       chrome.browserAction.setBadgeText({ text: '' })
  //       $('#icrm_all_satisfied').show()
  //     }
  //   })
  // })
})
