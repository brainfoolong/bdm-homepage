<?php
include __DIR__ . "/_bootloader.php";
?><!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>BrainDoesMusic - Slowstyle / EDM / Hands Up / Trance</title>
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Music produced by BrainDoesMusic!">
    <link rel="icon" type="image/svg+xml" href="media/logo.svg">
    <link rel="shortcut icon" type="image/svg+xml" href="media/logo.svg">
    <link rel="apple-touch-icon" type="image/svg+xml" href="media/logo.svg">
    <link rel="image_src" href="media/logo.svg">
    <style type="text/css">
      :root {
        --default-font: -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji;
      }

      html, body {
        padding: 0;
        margin: 0;
        font-family: var(--default-font);
        font-size: 16px;
        line-height: 1.4;
        color: white;
        overflow: hidden;
      }

      .app {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: #222;
        background-image: url(media/logo.svg);
        background-size: cover;
        background-position: bottom center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
      }

      .container {
        position: relative;
        padding: 10px;
        width: 100%;
        background: rgba(255, 255, 255, 0.8);
        text-align: center;
        display: flex;
        transition: .3s;
        border: 15px solid transparent;
        border-left-width: 0;
        border-right-width: 0;
        animation: fancy 5.0s infinite linear;
      }

      .videos {
        flex: 1 1 auto;
        max-width: 100%;
        overflow: hidden;
      }

      .video {
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      .video header {
        flex: 0 0 auto;
        font-weight: bold;
        font-size: 24px;
        margin-bottom: 10px;
        word-break: break-all;
      }

      .video .video-body {
        flex: 1 1 auto;
        width: 100%;
        max-width: 600px;
        height: 400px;
        border-radius: 20px;
      }

      .video .video-footer {
        color: #666;
        padding: 10px;
        word-break: break-word;
        max-height: 55px;
      }

      .btn-left,
      .btn-right {
        margin: 10px;
        cursor: pointer;
        min-width: 60px;
        max-width: 60px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 40px;
      }

      .hidden {
        display: none !important;
      }

      .animate-left-out {
        transform: rotateY(90deg) rotateZ(-30deg);
      }

      .animate-right-out {
        transform: rotateY(90deg) rotateZ(30deg);
      }

      .animate-in {
        transform: rotate(0);
      }

      @keyframes fancy {
        100%, 0% {
          border-color: rgb(255, 0, 0);
        }
        8% {
          border-color: rgb(255, 127, 0);
        }
        16% {
          border-color: rgb(255, 255, 0);
        }
        25% {
          border-color: rgb(127, 255, 0);
        }
        33% {
          border-color: rgb(0, 255, 0);
        }
        41% {
          border-color: rgb(0, 255, 127);
        }
        50% {
          border-color: rgb(0, 255, 255);
        }
        58% {
          border-color: rgb(0, 127, 255);
        }
        66% {
          border-color: rgb(0, 0, 255);
        }
        75% {
          border-color: rgb(127, 0, 255);
        }
        83% {
          border-color: rgb(255, 0, 255);
        }
        91% {
          border-color: rgb(255, 0, 127);
        }
      }
      .imp {
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 10px;
        color: white;
        cursor: pointer;
      }

    </style>
</head>
<body>
<div class="app">
    <div class="container">
        <div class="btn-left">&lt;</div>
        <div class="videos">
            <article class="video">
                <header></header>
                <iframe class="video-body"
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                <div class="video-footer"></div>
            </article>
        </div>
        <div class="btn-right">&gt;</div>
    </div>
    <div class="imp">Imprint</div>
</div>

<script>
  (function () {
    function loadHash (hash, type) {
      let videoRow = null
      for (let i = 0; i < videos.length; i++) {
        let videoData = videos[i]
        if (videoData.id === hash) {
          videoRow = videoData
          break
        }
      }
      if (!videoRow) {
        videoRow = videos[0]
      }
      clearTimeout(to)
      container.classList.remove('animate-right-out')
      container.classList.remove('animate-left-out')
      container.classList.add('animate-' + type + '-out')
      to = setTimeout(function () {
        container.classList.remove('animate-right-out')
        container.classList.remove('animate-left-out')
        video.querySelector('header').innerText = videoRow.title
        video.querySelector('iframe').src = 'https://www.youtube-nocookie.com/embed/' + videoRow.id
        video.querySelector('.video-footer').innerText = videoRow.description
        currentVideoRow = videoRow
      }, currentVideoRow ? 300 : 0)
    }

    let to = null
    let currentVideoRow = null
    let container = document.querySelector('.container')
    let video = document.querySelector('.video')
    let videos = <?=file_get_contents(__DIR__ . "/videos.json")?>;

    document.querySelector('.btn-left').addEventListener('click', function () {
      let newId = null
      for (let i = 0; i < videos.length; i++) {
        let videoData = videos[i]
        if (currentVideoRow && currentVideoRow.id === videoData.id) {
          newId = (videos[i - 1] || {}).id || null
          break
        }
      }
      if (!newId) {
        newId = videos[videos.length - 1].id
      }
      loadHash(newId, 'left')
    }, false)

    document.querySelector('.btn-right').addEventListener('click', function () {
      let newId = null
      for (let i = 0; i < videos.length; i++) {
        let videoData = videos[i]
        if (currentVideoRow && currentVideoRow.id === videoData.id) {
          newId = (videos[i + 1] || {}).id || null
          break
        }
      }
      if (!newId) {
        newId = videos[0].id
      }
      loadHash(newId, 'right')
    }, false)

    document.querySelector('.imp').addEventListener('click', function () {
      window.open('imprint.html')
    }, false)

    loadHash(location.hash, 'left')

    if (location.host.match(/braindoesmusic\.com/)) {
      window._paq = window._paq || []
      _paq.push(['disableCookies'])
      _paq.push(['setCookieDomain', '*.braindoesmusic.com'])
      _paq.push(['trackPageView'])
      _paq.push(['enableLinkTracking']);
      (function () {
        let u = '//matomo.0x.at/'
        _paq.push(['setTrackerUrl', u + 't.php'])
        _paq.push(['setSiteId', '7'])
        let d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0]
        g.type = 'text/javascript'
        g.async = true
        g.defer = true
        g.src = u + 't.js'
        s.parentNode.insertBefore(g, s)
      })()
    }
  })()
</script>
</body>
</html>