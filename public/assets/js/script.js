/**
 * SideMenuLite
 * A JavaScript class for creating customizable side menus.
 *
 * @version 1.0.0
 * @license MIT License
 * @author Dmytro Lobov
 * @url https://wow-estore.com/item/side-menu-pro/
 */

'use strict';

class SideMenuLite {
  constructor(options) {
    const defaultOptions = {
      showAfterTimer: false,
      hideAfterTimer: false,
      showAfterPosition: false,
      hideAfterPosition: false,
      touch: false,
      mobile: false,
      mobileStyle: {},
      mobileHide: false,
      desktopHide: false,
      style: {},
      items: {},
      scrollSpyOffset: 50,
    };

    this.settings = {...defaultOptions, ...options};
    this.element = document.getElementById(this.settings.element);
  }

  touchThis() {
    if (this.settings.touch) {
      return;
    }

    document.querySelector('#'+this.settings.element).addEventListener('touchstart', function() {
      this.classList.add('sm-open');
    });

    const links = Array.from(this.element.querySelectorAll('.sm-link'));
    links.forEach((link) => {
      link.addEventListener('touchend', this.toggleItemOpen.bind(this, link));
    });
  }

  toggleItemOpen(link, event) {
    const item = link.closest('.sm-item');
    const {classList} = item;

    if (!classList.contains('sm-open')) {
      event.preventDefault();
      classList.add('sm-open');
      this.touchAnyWhere(link, classList);
    }
  }

  touchAnyWhere(link, classList) {
    document.addEventListener('touchstart', function (event) {
      if (!link.contains(event.target)) {
        classList.remove('sm-open')
      }
    });
  }

  displayMenu() {
    if (!this.settings.showAfterTimer && !this.settings.showAfterPosition) {
      this.showMenu();
    }

    this.settings.showAfterTimer && this.showAfterTimer(this.settings.showAfterTimer);
    this.settings.hideAfterTimer && this.hideAfterTimer(this.settings.hideAfterTimer);
    this.settings.hideAfterPosition && this.hideAfterPosition(this.settings.hideAfterPosition);
    this.settings.showAfterPosition && this.showAfterPosition(this.settings.showAfterPosition);
  }

  showMenu() {
    this.element.classList.remove('is-hidden');
    this.subMenuWidth();
  }

  hideMenu() {
    this.element.classList.add('is-hidden');
  }

  showAfterTimer() {
    setTimeout(() => this.showMenu(), this.settings.showAfterTimer * 1000);
  }

  hideAfterTimer() {
    setTimeout(() => this.element.classList.add('is-hidden'), this.settings.hideAfterTimer * 1000);
  }

  showAfterPosition() {
    window.addEventListener('scroll', () => {
      const shouldHide = window.scrollY <= this.settings.showAfterPosition;
      if(!shouldHide) {
        this.showMenu();
      } else {
        this.hideMenu();
      }
    });
  }

  hideAfterPosition() {
    window.addEventListener('scroll', () => {
      const shouldHide = window.scrollY > this.settings.hideAfterPosition;
      if(!shouldHide) {
        this.showMenu();
      } else {
        this.hideMenu();
      }
    });
  }

  actionServices() {
    this.element.addEventListener('click', (event) => {
      const target = event.target.closest('[data-btn-action]');
      if (!target) return;

      event.preventDefault();
      const action = target.getAttribute('data-btn-action');
      this.handleAction(action, target);
    });
  }

  handleAction(action, link) {
    const actionMap = {
      print: () => window.print(),
      goback: () => window.history.back(),
      goforward: () => window.history.forward(),
      scroll: () => {
        const anchor = link.getAttribute('href');
        const element = document.querySelector(anchor);
        element.scrollIntoView({behavior: 'smooth', block: 'start', inline: 'nearest'});
      },
      totop: () => window.scrollTo({top: 0, behavior: 'smooth'}),
      tobottom: () => window.scrollTo({top: document.body.scrollHeight, behavior: 'smooth'}),
    };

    const actionFunction = actionMap[action];
    if (actionFunction) {
      actionFunction();
    }
  }

  shareServices() {
    const links = this.element.querySelectorAll('[data-btn-share]');
    links.forEach(link => {
      link.addEventListener('click', () => {
        this.shareThis(link);
      });
    });
  }

  shareThis(link) {
    const service = link.getAttribute('data-btn-share');
    const shareData = this.defaultShareServices();
    const shareService = shareData[service];

    const winWidth = 550;
    const winHeight = 450;
    const topPosition = (screen.height - winHeight) / 2;
    const leftPosition = (screen.width - winWidth) / 2;

    const winParams = `
    menubar=no,
    toolbar=no,
    location=no,
    scrollbars=no,
    status=no,
    resizable=yes,
    width=${winWidth},
    height=${winHeight},
    top=${topPosition},
    left=${leftPosition}
  `;

    window.open(shareService.url, null, winParams);
  }


  defaultShareServices() {
    const PAGE_URL = encodeURIComponent(document.location.href);
    const PAGE_TITLE = encodeURIComponent(document.title);

    return {
      'blogger': {
        url: `https://www.blogger.com/blog-this.g?u=${PAGE_URL}&n=${PAGE_TITLE}`,
      },
      'buffer': {
        url: `https://buffer.com/add?text=${PAGE_TITLE}&url=${PAGE_URL}`,
      },
      'diaspora': {
        url: `https://share.diasporafoundation.org/?title=${PAGE_TITLE}&url=${PAGE_URL}`,
      },
      'digg': {
        url: `http://digg.com/submit?url=${PAGE_URL}`,
      },
      'douban': {
        url: `http://www.douban.com/recommend/?url=${PAGE_URL}&title=${PAGE_TITLE}`,
      },

      'draugiem': {
        url: `https://www.draugiem.lv/say/ext/add.php?title=${PAGE_TITLE}&url=${PAGE_URL}`,
      },
      'email': {
        url: `mailto:?subject=${PAGE_TITLE}&body=${PAGE_URL}`,
      },
      'evernote': {
        url: `http://www.evernote.com/clip.action?url=${PAGE_URL}&title=${PAGE_TITLE}`,
      },
      'facebook': {
        url: `https://www.facebook.com/sharer.php?u=${PAGE_URL}`,
      },
      'flipboard': {
        url: `https://share.flipboard.com/bookmarklet/popout?v=2&title=${PAGE_TITLE}&url=${PAGE_URL}`,
      },
      'google-bookmarks': {
        url: `https://www.google.com/bookmarks/mark?op=edit&bkmk=${PAGE_URL}&title=${PAGE_TITLE}`,
      },
      'googleplus': {
        url: `https://plus.google.com/share?url=${PAGE_URL}`,
      },
      'hacker-news': {
        url: `https://news.ycombinator.com/submitlink?u=${PAGE_URL}&t=${PAGE_TITLE}`,
      },
      'instapaper': {
        url: `http://www.instapaper.com/edit?url=${PAGE_URL}&title=${PAGE_TITLE}`,
      },
      'line': {
        url: `https://lineit.line.me/share/ui?url=${PAGE_URL}`,
      },
      'linkedin': {
        url: `https://www.linkedin.com/shareArticle?mini=true&url=${PAGE_URL}&title=${PAGE_TITLE}`,
      },
      'livejournal': {
        url: `http://www.livejournal.com/update.bml?subject=${PAGE_TITLE}&event=${PAGE_URL}`,
      },
      'myspace': {
        url: `https://myspace.com/post?u=${PAGE_URL}&t=${PAGE_TITLE}`,
      },
      'odnoklassniki': {
        url: `https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=${PAGE_URL}`,
      },
      'pinterest': {
        url: `http://pinterest.com/pin/create/button/?url=${PAGE_URL}`,
      },
      'pocket': {
        url: `https://getpocket.com/edit?url=${PAGE_URL}`,
      },
      'qzone': {
        url: `http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=${PAGE_URL}`,
      },
      'reddit': {
        url: `http://www.reddit.com/submit?url=${PAGE_URL}&title=${PAGE_TITLE}`,
      },
      'renren': {
        url: `http://widget.renren.com/dialog/share?resourceUrl=${PAGE_URL}&srcUrl=${PAGE_URL}&title=${PAGE_TITLE}`,
      },
      'skype': {
        url: `https://web.skype.com/share?url=${PAGE_URL}`,
      },
      'stumbleupon': {
        url: 'http://www.stumbleupon.com/submit?url=${PAGE_URL}&title=${PAGE_TITLE}',
      },
      'telegram': {
        url: `https://telegram.me/share/url?url=${PAGE_URL}&text=${PAGE_TITLE}`,
      },
      'tumblr': {
        url: `https://www.tumblr.com/widgets/share/tool?canonicalUrl=${PAGE_URL}&title=${PAGE_TITLE}`,
      },
      'twitter': {
        url: `https://twitter.com/intent/tweet?url=${PAGE_URL}&text=${PAGE_TITLE}`,
      },
      'vk': {
        url: `http://vk.com/share.php?url=${PAGE_URL}&title=${PAGE_TITLE}`,
      },
      'weibo': {
        url: `http://service.weibo.com/share/share.php?url=${PAGE_URL}&title=${PAGE_TITLE}`,
      },
      'whatsapp': {
        url: `whatsapp://send?text=${PAGE_TITLE}%20%0A${PAGE_URL}`,
      },
      'xing': {
        url: `https://www.xing.com/spi/shares/new?url=${PAGE_URL}`,
      },
    };
  }

  toggleMenu() {
    const elements = this.element.querySelectorAll('[data-smmenu-target]');
    if(!elements) {
      return false;
    }

    if(this.element.classList.contains('sm-connected')) {
      elements.forEach(element => {

        element.addEventListener('click', () => {
          const toogle = element.getAttribute('data-smmenu-target');
          if(toogle === 'close') {
            this.element.classList.remove('sm-open');
          }
        });

        element.addEventListener('touchend', () => {
          const toogle = element.getAttribute('data-smmenu-target');
          if(toogle === 'close') {
            this.element.classList.remove('sm-open');
          }
        });

      });
    }
  }

  run() {
    this.style();
    this.itemStyle();
    this.touchThis();
    this.displayMenu();
    this.actionServices();
    this.shareServices();
    this.translate();
    this.scrollSpy();
    this.toggleMenu();
  }

  scrollSpy() {

    const navbarLinks = [...this.element.querySelectorAll('.sm-link[data-btn-action="scrollSpy"]')];
    if (navbarLinks.length < 1) {
      return false;
    }

    const sections = navbarLinks.map(link => document.querySelector(link.getAttribute('href')));

    navbarLinks.forEach(link => {
      link.addEventListener('click', () => {
        const parent = link.closest('.sm-item');
        const anchor = link.getAttribute('href');
        const element = document.querySelector(anchor);
        if(!element) {
          return;
        }
        element.scrollIntoView({behavior: 'smooth', block: 'start', inline: 'nearest'});

        navbarLinks.forEach(navLink => {
          const parent = link.closest('.sm-item');
          parent.classList.remove('sm-open');
        });
        parent.classList.add('sm-open');
      });
    });

    window.addEventListener('scroll', () => {
      const currentScroll = window.pageYOffset;

      sections.forEach(section => {
        if(section === null) {
          return;
        }
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;

        if (currentScroll >= sectionTop - this.settings.scrollSpyOffset  && currentScroll < sectionTop + sectionHeight) {
          const sectionId = section.getAttribute('id');
          setActiveLink(sectionId);
        }
      });
    });

    function setActiveLink(sectionId) {
      navbarLinks.forEach(link => {
        const parent = link.closest('.sm-item');
        if (link.getAttribute('href') === `#${sectionId}`) {
          parent.classList.add('sm-open');
        } else {
          parent.classList.remove('sm-open');
        }
      });
    }
  }

  translate() {
    const languages = this.element.querySelectorAll('[data-google-lang]');
    if (languages.length > 0) {
      this.appendScript();
    }
  }

  appendScript() {
    const head = document.head;
    const script = document.createElement('script');
    script.src = 'https://translate.google.com/translate_a/element.js?cb=SMPTranslateInit';
    script.setAttribute('defer', '');
    head.appendChild(script);

    const styleElement = document.createElement('style');
    styleElement.textContent = '.skiptranslate {display: none !important;}body {top: 0 !important}';
    head.appendChild(styleElement);
  }

  static Translate() {
    const doc = document;
    const win = window;
    const deflang = doc.documentElement.lang.slice(0, 2);
    const lang = this.getLanguage(deflang);

    if (lang === deflang) {
      this.clearCookie();
    }

    const languages = Array.from(doc.querySelectorAll('[data-google-lang]'));

    if (!languages.length) {
      return false;
    }

    new google.translate.TranslateElement({
      pageLanguage: deflang,
    });

    languages.forEach((language) => {
      language.addEventListener('click', (e) => {
        e.preventDefault();
        let lang = language.getAttribute('data-google-lang');
        this.setCookie(lang);
        win.location.reload();
      });
    });
  }

  static getLanguage(lang) {
    const keyValue = document['cookie'].match('(^|;) ?googtrans=([^;]*)(;|$)');
    const cookieLang = keyValue ? keyValue[2].split('/')[2] : null;
    return (cookieLang !== undefined && cookieLang !== 'null') ? cookieLang : lang;
  }

  static clearCookie() {
    document.cookie = 'googtrans=null';
    document.cookie = 'googtrans=null; domain=' + document.domain;
  }

  static setCookie(lang) {
    document.cookie = 'googtrans=/auto/' + lang;
    document.cookie = 'googtrans=/auto/' + lang + '; domain=' + document.domain;
  }


  style() {
    const styles = this.settings.style;
    const styleEntries = Object.entries(styles);
    const style = styleEntries
    .map(([property, value]) => `${property}: ${value};`)
    .join('');

    let mobileStyle = '';
    if(this.settings.mobile) {
      const styles = this.settings.mobileStyle;
      const styleEntries = Object.entries(styles);
      const style = styleEntries
      .map(([property, value]) => `${property}: ${value};`)
      .join('');

      mobileStyle = `@media only screen and (max-width: ${this.settings.mobile}px){ #${this.settings.element} {${style}}}`;
    }

    let mobileHide = '';
    if(this.settings.mobileHide) {
      mobileHide = `@media only screen and (max-width: ${this.settings.mobileHide}px){#${this.settings.element} {display:none;}}`;
    }

    let desktopHide = '';
    if(this.settings.desktopHide) {
      desktopHide = `@media only screen and (min-width: ${this.settings.desktopHide}px){#${this.settings.element} {display:none;}}`;
    }

    const targetStyleElement = document.getElementById('side-menu-css');

    const styleElement = document.createElement('style');
    styleElement.setAttribute('id', 'side-menu-js-css');
    styleElement.innerHTML = `#${this.settings.element} {${style}} ${mobileStyle} ${mobileHide} ${desktopHide}`;

    if(targetStyleElement) {
      targetStyleElement.parentNode.insertBefore(styleElement, targetStyleElement.nextSibling);
    } else {
      document.body.appendChild(styleElement);
    }



  }

  itemStyle() {
    const itemsObj = this.settings.items;
    const items = Array.from(this.element.querySelectorAll('.sm-item'));

    Object.entries(itemsObj).forEach(([key, value]) => {
      for (const property in value) {
        if (value.hasOwnProperty(property)) {
          items[key].style.setProperty(property, value[property]);
        }
      }
    });
  }

  subMenuWidth() {
    const items = this.element.querySelectorAll('.sm-has-submenu');
    items.forEach((item) => {
      const itemWidth = item.clientWidth;
      const submenu = item.querySelector('.sm-sub-menu');
      const width = submenu.clientWidth;
      if (itemWidth < width) {
        const link = item.querySelector('.sm-link');
        link.style.width = `${width}px`;
      } else {
        const links = submenu.querySelectorAll('.sm-link');
        links.forEach((link) => {
          link.style.width = `${itemWidth}px`;
        });
      }
    });
  }

  static initialize(options) {
    const sideMenuPro = new SideMenuLite(options);
    sideMenuPro.run();
    return sideMenuPro;
  }
}

document.addEventListener('DOMContentLoaded', function() {
  for (let key in window) {
    if (key.indexOf('SideMenuLite_') >= 0) {
      const val = window[key];
      new SideMenuLite(val);
      SideMenuLite.initialize(val);
    }
  }
});

const GoogleTranslateInit = function() {
  const defaultLanguage = document.documentElement.lang.slice(0, 2);

  function getLanguage() {
    const keyValue = document['cookie'].match('(^|;) ?googtrans=([^;]*)(;|$)');
    const cookieLang = keyValue ? keyValue[2].split('/')[2] : null;
    return (cookieLang !== undefined && cookieLang !== 'null') ? cookieLang : defaultLanguage;
  }

  function clearCookie() {
    document.cookie = 'googtrans=null';
    document.cookie = 'googtrans=null; domain=' + document.domain;
  }

  function setCookie(lang) {
    document.cookie = 'googtrans=/auto/' + lang;
    document.cookie = 'googtrans=/auto/' + lang + '; domain=' + document.domain;
  }

  function run() {
    const language = getLanguage();

    if (language === defaultLanguage) {
      clearCookie();
    }

    new google.translate.TranslateElement({
      pageLanguage: defaultLanguage,
    });

    const languages = document.querySelectorAll('[data-google-lang]');

    if (!languages) {
      return false;
    }

    languages.forEach((language) => {
      language.addEventListener('click', (e) => {
        e.preventDefault();
        let lang = language.getAttribute('data-google-lang');
        setCookie(lang);
        window.location.reload();
      });
    });

  }

  return run();
};

function SMPTranslateInit() {
  SideMenuLite.Translate();
}