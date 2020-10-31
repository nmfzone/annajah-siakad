$(function () {
  const navigation = $('.main-navbar')
  const wpAdminBar = $('#wpadminbar')
  let topClass = 'top-0'
  let stickyNavAlreadyShown = false
  const logo = navigation.find('.logo-box .logo')
  const randNum = Math.floor((Math.random() * 100) + 1)
  const navHeight = navigation.height()

  if (!$('body').hasClass('full-menu')) {
    $(window).scroll(function () {
      const scroll = $(window).scrollTop()

      if (wpAdminBar.length) {
        if (window.innerWidth > 782) {
          topClass = 'top-30'
        } else if (window.innerWidth > 600) {
          topClass = 'top-45'
        } else {
          topClass = 'top-0'
        }
      }

      if (!stickyNavAlreadyShown && scroll >= 20) {
        navigation.addClass(`sticky ${topClass}`)
        navigation.parent().append(`<div class="tmp-nav-${randNum} w-full" style="height: ${navHeight}px"></div>`)
        logo.css({opacity: 0})
        logo.css({opacity: 1})
        stickyNavAlreadyShown = true
      } else if (stickyNavAlreadyShown && scroll < 20) {
        navigation.removeClass(`sticky ${topClass}`)
        navigation.parent().find(`.tmp-nav-${randNum}`).remove()
        stickyNavAlreadyShown = false
      }
    })
  }
})
