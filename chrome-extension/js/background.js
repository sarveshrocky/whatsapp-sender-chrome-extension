console.log('BACKGROUND STARTED')

// 1. Check that WA tab is open
chrome.alarms.create('ALARM_ENSURE_WA_TAB_IS_OPEN', {
  when: Date.now() + 2000,
  periodInMinutes: 1
})

// 2. Listen to "Check for new messages" event
chrome.runtime.onMessageExternal.addListener(
  function(request, sender, sendResponse) {
    var xhr

    if (request.type === "MESSAGE_SENT") {
      xhr = $.post(CRM_PATH + '/api/messages/confirm', {
        id: request.commentId,
        version: chrome.runtime.getManifest().version
      })
      xhr.done(function (data) {
        console.log('updateXHR::success', data)
        sendResponse({
          status: 'ok',
          commentId: request.commentId
        })
      })
      xhr.fail(function (err) {
        console.error('updateXHR::error', err)
        sendResponse({
          status: 'error',
          commentId: request.commentId
        });
      })
    }

    if (request.type === "MESSAGE_NOT_SENT") {
      xhr = $.post(CRM_PATH + '/api/messages/reject', {
        id: request.commentId,
        reason: request.reason,
        version: chrome.runtime.getManifest().version
      })
      xhr.done(function (data) {
        console.log('updateXHR::success', data)
        sendResponse({
          status: 'ok',
          commentId: request.commentId
        })
      })
      xhr.fail(function (err) {
        console.error('updateXHR::error', err)
        sendResponse({
          status: 'error',
          commentId: request.commentId
        });
      })
    }

    if (request.type === "CHECK_NEW_MESSAGE") {
      console.log('Check new message');

      var n_ = request['lastWid'].match(/\d+/, '')
      var lwk
      if (n_ && n_[0]) {
        lwk = n_[0]
      } else {
        lwk = '__not_authorized__'
      }

      var selectXhr = $.getJSON(CRM_PATH + '/api/messages', {
        version: chrome.runtime.getManifest().version,
        last_wid: lwk
      })
      selectXhr.done(function (data) {
        if (data['status'] === 'ok') {
          console.log('Received comments', data['payload'])
          sendResponse({
            count: data['payload'].length,
            comments: data['payload']
          })
        }
      })
      selectXhr.fail(function (err) {
        console.error('selectXHR', err)
        sendResponse({
          count: 0,
          comments: []
        })
      })
    }
    return true;
  }
);

// Alarms
chrome.alarms.onAlarm.addListener(function (alarm) {
  if (alarm['name'] === 'ALARM_ENSURE_WA_TAB_IS_OPEN') {
    chrome.tabs.query({ currentWindow: true }, function (tabs) {
      var tabFound = false
      tabs.forEach(function (tab) {
        if (tab['url'].indexOf('web.whatsapp.com') !== -1) {
          tabFound = true
        }
      })
      if (!tabFound) {
        chrome.tabs.create({
          url: encodeURI('https://web.whatsapp.com'),
          active: false
        })
      }
    })
  }
})
