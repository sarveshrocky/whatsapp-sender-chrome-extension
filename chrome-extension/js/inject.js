(function () {
  var div = document.createElement('div');
  div.style.position = 'fixed';
  div.style.top = 0;
  div.style.right = 0;
  div.textContent = '*';
  document.body.appendChild(div);

  var timer = setInterval(function () {
    var btn = document.querySelector('.compose-btn-send')
    if (btn) {
      btn.click();
      clearInterval(timer)
      chrome.runtime.sendMessage({ type: 'COMMENT_SENT' })
    }
  }, 10000)
})()
