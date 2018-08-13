
var actualCode = '(' + function (extId) {

  var lastWid = window.localStorage['last-wid']

  function findChatComponent(dom) {
    var result = null
    for (var key in dom)
      if (key.startsWith("__reactInternalInstance$")) {
        // No longer works
        // var compInternals = dom[key]._currentElement;
        // var compWrapper = compInternals._owner;
        // return compWrapper._instance;

        try {
          // temp1.lastEffect.stateNode.props.children._owner.stateNode.props.chat.sendMessage
          // child.child.memoizedProps.children._owner.stateNode.props.chat
          result = dom[key].child.child.memoizedProps.children._owner.stateNode.props.chat
        } catch (e) {
          try {
            // temp1.sibling.sibling.memoizedProps.chat.sendMessage
            // child.sibling.sibling.pendingProps.chat
            result = dom[key].child.sibling.sibling.pendingProps.chat
          } catch (e) {}
        }
      }
    return result
  }

  function checkForNewMessage () {
    chrome.runtime.sendMessage(extId, {
      type: 'CHECK_NEW_MESSAGE',
      lastWid: lastWid
    }, function (res) {
      if (res && res['count'] > 0) {
        var comment = res['comments'][0]
        window.localStorage.setItem('__wae_comment_id', comment.id)
        window.localStorage.setItem('__wae_comment_phone', comment.phone)
        window.localStorage.setItem('__wae_comment_text', comment.text)
        window.location.replace(
          encodeURI('https://web.whatsapp.com/send?phone=' + comment.phone + '&text=' + comment.text + '&cid=' + comment.id)
        )
      } else {
        window.localStorage.removeItem('__wae_comment_id')
        window.localStorage.removeItem('__wae_comment_phone')
        window.localStorage.removeItem('__wae_comment_text')
        setTimeout(checkForNewMessage, 30000)
      }
    })
  }

  var phone = window.localStorage.getItem('__wae_comment_phone')
  var text = window.localStorage.getItem('__wae_comment_text')
  var commentId = window.localStorage.getItem('__wae_comment_id')

  if (phone && text && commentId && lastWid) {
    var tryCount = 0
    setTimeout(function sendMessage () {
      var chat = findChatComponent(document.getElementsByTagName('footer')[0]);
      if (chat) {
        var res = chat.sendMessage(decodeURI(text))
        res.then(function () {
          chrome.runtime.sendMessage(extId, {
            type: 'MESSAGE_SENT',
            commentId: commentId
          }, function (res) {
            var inputBox = document.getElementsByClassName('copyable-text selectable-text')
            if (inputBox) {
              inputBox[inputBox.length - 1].innerHTML = ''
            }
            if (res.status) {
              setTimeout(checkForNewMessage, 1000)
            }
          })
        })
        res.catch(function () {
          chrome.runtime.sendMessage(extId, {
            type: 'MESSAGE_NOT_SENT',
            commentId: commentId
          }, function () {
            setTimeout(checkForNewMessage, 1000)
          })
        })
      } else {
        tryCount += 1
        if (tryCount > 20) {
          var rejectionText = ''
          var popupContainer = document.getElementsByClassName('popup-container')[0]
          if (popupContainer) {
            var popupBody = document.getElementsByClassName('popup-body')[0]
            if (popupBody) {
              rejectionText = popupBody.innerText
            }
          }
          chrome.runtime.sendMessage(extId, {
            type: 'MESSAGE_NOT_SENT',
            commentId: commentId,
            reason: rejectionText
          })
          setTimeout(function () {
            checkForNewMessage()
          }, 10000)
        } else {
          setTimeout(sendMessage, 1000)
        }
      }
    }, 1000)
  }
  else {
    setTimeout(checkForNewMessage, 20000)
  }
} + ')(' + JSON.stringify(chrome.runtime.id) + ');';

var script = document.createElement('script');
script.textContent = actualCode;
(document.head||document.documentElement).appendChild(script);
script.onload = function() {
  // script.parentNode.removeChild(script);
};
