(function () {
  'use strict';

  /* Sheehan Health — behaviour layer (vanilla JS, no dependencies). */

  /* ===================================================================
     HeroSignature — animated brand signature in the hero
     =================================================================== */
  var HERO_DURATION = 7000;
  var HERO_WRITE_START = 0.4755;
  var HERO_LOGO_REVEAL_START = 0.4787;
  var HERO_LOGO_REVEAL_END = 0.9955;

  function HeroSignature(stage) {
    this.stage = stage;
    this.animations = [];
  }
  HeroSignature.mount = function (root) {
    root = root || document;
    var stage = root.querySelector('[data-hero-stage]');
    if (!stage || typeof stage.animate !== 'function') return null;
    var hero = new HeroSignature(stage);
    hero.init();
    return hero;
  };
  HeroSignature.prototype.$ = function (sel) { return this.stage.querySelector(sel); };
  HeroSignature.prototype.animate = function (el, keyframes, options) {
    if (!el) return;
    this.animations.push(el.animate(keyframes, Object.assign({ easing: 'linear', fill: 'both' }, options)));
  };
  HeroSignature.prototype.init = function () {
    var self = this;
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function () { self.play(); }, { once: true });
    } else {
      self.play();
    }
  };
  HeroSignature.prototype.play = function () {
    this.cancel();
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      this.settle();
      return;
    }

    if (window.innerWidth && window.innerWidth < 768) {
      this.animate(this.$('[data-hero-sig]'),
        [{ clipPath: 'inset(0 100% 0 0)', webkitClipPath: 'inset(0 100% 0 0)' },
         { clipPath: 'inset(0 0 0 0)', webkitClipPath: 'inset(0 0 0 0)' }],
        { duration: 1400, easing: 'ease-in-out' });
      this.animate(this.$('[data-hero-nurse]'),
        [{ opacity: 0, transform: 'translateY(8px)' }, { opacity: 1, transform: 'translateY(0)' }],
        { delay: 1450, duration: 550, easing: 'cubic-bezier(.2,.7,.2,1)' });
      this.guard();
      return;
    }

    var D = HERO_DURATION, W = HERO_WRITE_START;
    this.animate(this.$('[data-hero-line]'),
      [{ strokeDashoffset: 589 }, { strokeDashoffset: 0 }],
      { duration: D * W });
    this.animate(this.$('[data-hero-sig]'),
      [{ clipPath: 'inset(0 100% 0 0)', webkitClipPath: 'inset(0 100% 0 0)' }, { clipPath: 'inset(0 0 0 0)', webkitClipPath: 'inset(0 0 0 0)' }],
      { delay: D * HERO_LOGO_REVEAL_START, duration: D * (HERO_LOGO_REVEAL_END - HERO_LOGO_REVEAL_START) });
    this.animate(this.$('[data-hero-pen]'),
      [{ offsetDistance: '0%' }, { offsetDistance: '100%' }],
      { duration: D });
    this.animate(this.$('[data-hero-pen]'),
      [{ opacity: 0 }, { opacity: 1, offset: 0.04 }, { opacity: 1, offset: 0.95 }, { opacity: 0 }],
      { duration: D });
    this.animate(this.$('[data-hero-nurse]'),
      [{ opacity: 0, transform: 'translateY(10px)' }, { opacity: 1, transform: 'translateY(0)' }],
      { delay: D + 150, duration: 700, easing: 'cubic-bezier(.2,.7,.2,1)' });
    this.guard();
  };
  HeroSignature.prototype.guard = function () {
    var self = this;
    var probe = this.animations[0];
    var before = probe ? (probe.currentTime || 0) : 0;
    setTimeout(function () {
      var after = probe ? (probe.currentTime || 0) : 0;
      if (after <= before) self.settle();
    }, 300);
  };
  HeroSignature.prototype.cancel = function () {
    for (var i = 0; i < this.animations.length; i++) {
      try { this.animations[i].cancel(); } catch (e) {}
    }
    this.animations = [];
  };
  HeroSignature.prototype.settle = function () {
    for (var i = 0; i < this.animations.length; i++) {
      try { this.animations[i].finish(); } catch (e) {}
    }
    var sig = this.$('[data-hero-sig]');
    var nurse = this.$('[data-hero-nurse]');
    var line = this.$('[data-hero-line]');
    if (sig) { sig.style.webkitClipPath = 'inset(0 0 0 0)'; sig.style.clipPath = 'inset(0 0 0 0)'; }
    if (nurse) nurse.style.opacity = '1';
    if (line) line.style.strokeDashoffset = '0';
  };

  /* ScrollReveal */
  function ScrollReveal(targets) {
    var self = this;
    this.targets = Array.prototype.slice.call(targets);
    this.onScroll = function () { self.check(); };
    window.addEventListener('scroll', this.onScroll, { passive: true });
    window.addEventListener('resize', this.onScroll);
    this.check();
  }
  ScrollReveal.mount = function (root) {
    root = root || document;
    var targets = root.querySelectorAll('.reveal');
    if (!targets.length) return null;
    return new ScrollReveal(targets);
  };
  ScrollReveal.prototype.check = function () {
    var vh = window.innerHeight || document.documentElement.clientHeight;
    var remaining = [];
    for (var i = 0; i < this.targets.length; i++) {
      var el = this.targets[i];
      if (el.getBoundingClientRect().top < vh * 0.92) {
        el.classList.add('is-visible');
      } else {
        remaining.push(el);
      }
    }
    this.targets = remaining;
    if (!this.targets.length) {
      window.removeEventListener('scroll', this.onScroll);
      window.removeEventListener('resize', this.onScroll);
    }
  };

  /* ===================================================================
     Navigation — sticky header shadow + mobile menu toggle
     =================================================================== */
  var NAV_SCROLL_ENTER = 20;
  var NAV_SCROLL_LEAVE = 6;
  function Navigation(nav) {
    this.nav = nav;
    this.toggle = document.getElementById('nav-toggle');
    this.links = document.getElementById('nav-links');
    this.backdrop = document.getElementById('nav-backdrop');
    this.bind();
  }
  Navigation.mount = function () {
    var nav = document.getElementById('site-nav');
    if (!nav) return null;
    return new Navigation(nav);
  };
  Navigation.prototype.closeDrawer = function () {
    this.links.classList.remove('is-open');
    if (this.backdrop) this.backdrop.classList.remove('is-open');
    document.body.classList.remove('nav-drawer-open');
  };
  Navigation.prototype.bind = function () {
    var self = this;
    var syncScrolled = function () {
      var y = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || 0;
      var isScrolled = self.nav.classList.contains('is-scrolled');
      // If the page is shorter than the viewport there's no scroll to
      // trigger the usual transparent-to-solid transition, so the nav
      // would stay transparent (unreadable) forever — force solid instead.
      // Same for any page with no dark hero image directly under the nav
      // (only body.has-hero, set on the homepage, ever needs transparency
      // at scroll position 0 — white content there is unreadable behind it).
      var noScrollRoom = document.documentElement.scrollHeight <= window.innerHeight;
      var noHero = !document.body.classList.contains('has-hero');
      if ( noScrollRoom || noHero || ( !isScrolled && y > NAV_SCROLL_ENTER ) ) {
        self.nav.classList.add('is-scrolled');
      } else if (isScrolled && y < NAV_SCROLL_LEAVE) {
        self.nav.classList.remove('is-scrolled');
      }
    };
    window.addEventListener('resize', syncScrolled);
    window.addEventListener('scroll', syncScrolled, { passive: true });
    window.addEventListener('touchmove', syncScrolled, { passive: true });
    syncScrolled();
    setInterval(syncScrolled, 250);
    if (this.toggle && this.links) {
      var self2 = this;
      this.toggle.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar') {
          e.preventDefault();
          self.toggle.click();
        }
      });
      this.toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        var overflowMenu = document.getElementById('nav-more-menu');
        if (!self.nav.classList.contains('is-compact') && overflowMenu && overflowMenu.children.length) {
          overflowMenu.classList.toggle('is-open');
        } else {
          var opening = !self.links.classList.contains('is-open');
          self.links.classList.toggle('is-open', opening);
          if (self.backdrop) self.backdrop.classList.toggle('is-open', opening);
          document.body.classList.toggle('nav-drawer-open', opening);
        }
      });
      if (this.backdrop) {
        this.backdrop.addEventListener('click', function () { self.closeDrawer(); });
      }
      var closeBtn = document.getElementById('nav-links-close');
      if (closeBtn) {
        closeBtn.addEventListener('click', function () { self.closeDrawer(); });
      }
      this.links.addEventListener('click', function (e) {
        if (e.target.closest && e.target.closest('.site-nav__link')) self.closeDrawer();
      });
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') self.closeDrawer();
      });
      document.addEventListener('click', function (e) {
        var overflowMenu = document.getElementById('nav-more-menu');
        if (overflowMenu && !overflowMenu.contains(e.target) && e.target !== self2.toggle && !self2.toggle.contains(e.target)) {
          overflowMenu.classList.remove('is-open');
        }
      });
    }
  };

  /* PriorityNav */
  function PriorityNav(nav) {
    this.nav = nav;
    this.center = nav.querySelector('.site-nav__center');
    this.linksWrap = nav.querySelector('#nav-links');
    this.login = nav.querySelector('.site-nav__login');
    this.toggle = nav.querySelector('.site-nav__toggle');
    this.logo = nav.querySelector('.site-nav__logo-mark');
    this.clinical = nav.querySelector('.site-nav__clinical');
    this.divider = nav.querySelector('.site-nav__divider');
    this.moreMenu = nav.querySelector('#nav-more-menu');
    if (!this.center || !this.linksWrap || !this.login || !this.toggle || !this.moreMenu) return;
    this.items = Array.prototype.slice.call(this.linksWrap.querySelectorAll('[data-nav-item]'));
    if (!this.items.length) return;
    this.run = this.run.bind(this);
    this._lastWidth = window.innerWidth;
    this.run();
    var debounceTimer = null;
    var self = this;
    window.addEventListener('resize', function (evt) {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(function () { self.run(evt); }, 120);
    });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(this.run);
    // Extra correctness pass after full page load — a run() during
    // construction can occasionally measure a transient/incorrect width
    // before layout settles, latching a wrong compact mode with no resize
    // event afterward to self-correct. Guard for 'load' having already
    // fired by the time this script runs (bottom-of-body <script>).
    if (document.readyState === 'complete') {
      this.run();
    } else {
      window.addEventListener('load', this.run);
    }
  }  PriorityNav.mount = function () {
    var nav = document.getElementById('site-nav');
    if (!nav) return null;
    return new PriorityNav(nav);
  };
  var MOBILE_NAV_BP = 767;
  PriorityNav.prototype.setCompact = function (compact) {
    var self = this;
    this.linksWrap.style.transition = 'none';
    this.nav.classList.toggle('is-compact', compact);
    void this.linksWrap.offsetHeight;
    requestAnimationFrame(function () {
      self.linksWrap.style.transition = '';
    });
  };
  PriorityNav.prototype.run = function (evt) {
    var self = this;
    if (evt && evt.type === 'resize') {
      var w = window.innerWidth;
      if (w === this._lastWidth) return;
      this._lastWidth = w;
    }

    var wasCompact = this.nav.classList.contains('is-compact');

    if (window.innerWidth <= MOBILE_NAV_BP) {
      if (!wasCompact) {
        this.items.forEach(function (el) { self.linksWrap.appendChild(el); });
        if (this.clinical) this.linksWrap.appendChild(this.clinical);
        this.setCompact(true);
      }
      return;
    }

    if (wasCompact) {
      this.items.forEach(function (el) { self.linksWrap.appendChild(el); });
      if (this.clinical) this.center.appendChild(this.clinical);
      this.setCompact(false);
    }

    var navRect = this.nav.getBoundingClientRect();
    var loginRect = this.login.getBoundingClientRect();
    var GAP = 64;
    var loginLeft = loginRect.left - navRect.left;
    var logoEl = (this.logo && getComputedStyle(this.logo).display !== 'none') ? this.logo : null;
    var logoRight = logoEl ? (logoEl.getBoundingClientRect().right - navRect.left) : 0;
    var centerRect = this.center.getBoundingClientRect();
    var available = loginLeft - logoRight - GAP * 2;
    var fits = centerRect.width <= available;

    if (!fits) {
      this.items.forEach(function (el) { self.linksWrap.appendChild(el); });
      if (this.clinical) this.linksWrap.appendChild(this.clinical);
      this.setCompact(true);
    }
    if (wasCompact && !this.nav.classList.contains('is-compact')) {
      this.linksWrap.classList.remove('is-open');
      var backdrop = document.getElementById('nav-backdrop');
      if (backdrop) backdrop.classList.remove('is-open');
      document.body.classList.remove('nav-drawer-open');
    }
  };

  /* ContactPanel — slide-in contact form. Real submission now goes through the CF7 shortcode rendered inside this panel (SMTP already configured); this JS only owns opening/closing/auto-open. */
  var PANEL_SCROLL_TRIGGER = 0.30;
  function ContactPanel(panel) {
    this.panel = panel;
    this.closeBtn = document.getElementById('panel-close');
    this.autoTriggered = false;
    this.dismissed = false;
    this.bind();
  }
  ContactPanel.mount = function () {
    var panel = document.getElementById('contact-panel');
    if (!panel) return null;
    return new ContactPanel(panel);
  };
  ContactPanel.prototype.bind = function () {
    var self = this;
    var triggers = document.querySelectorAll('[data-contact-open]');
    for (var i = 0; i < triggers.length; i++) {
      triggers[i].addEventListener('click', function (e) { e.preventDefault(); self.open(); });
    }
    this.handleScroll = function () { self.maybeAutoOpen(); };
    window.addEventListener('scroll', this.handleScroll, { passive: true });
    window.addEventListener('touchmove', this.handleScroll, { passive: true });
    window.addEventListener('resize', this.handleScroll);
    if (window.visualViewport) window.visualViewport.addEventListener('resize', this.handleScroll);
    this.pollId = setInterval(this.handleScroll, 150);
    if (this.closeBtn) this.closeBtn.addEventListener('click', function () { self.close(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') self.close(); });
  };
  ContactPanel.prototype.maybeAutoOpen = function () {
    if (this.autoTriggered || this.dismissed) return;
    var y = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
    var vh = (window.visualViewport && window.visualViewport.height) || window.innerHeight || document.documentElement.clientHeight || 0;
    var docHeight = Math.max(
      document.body.scrollHeight, document.documentElement.scrollHeight,
      document.body.offsetHeight, document.documentElement.offsetHeight
    );
    var scrollable = docHeight - vh;
    var progress = scrollable > 0 ? y / scrollable : 0;
    if (progress >= PANEL_SCROLL_TRIGGER) {
      this.autoTriggered = true;
      window.removeEventListener('scroll', this.handleScroll);
      window.removeEventListener('touchmove', this.handleScroll);
      window.removeEventListener('resize', this.handleScroll);
      if (window.visualViewport) window.visualViewport.removeEventListener('resize', this.handleScroll);
      clearInterval(this.pollId);
      this.open();
    }
  };
  ContactPanel.prototype.open = function () { this.panel.classList.add('is-open'); };
  ContactPanel.prototype.close = function () {
    var self = this;
    this.dismissed = true;
    window.removeEventListener('scroll', this.handleScroll);
    window.removeEventListener('touchmove', this.handleScroll);
    window.removeEventListener('resize', this.handleScroll);
    if (window.visualViewport) window.visualViewport.removeEventListener('resize', this.handleScroll);
    clearInterval(this.pollId);
    this.panel.classList.add('is-closing');
    this.panel.classList.remove('is-open');
    setTimeout(function () { self.panel.classList.remove('is-closing'); }, 50);
  };

  /* FloatingCtaVisibility */
  function FloatingCtaVisibility(el) {
    this.el = el;
    this.hero = document.querySelector('.hero');
    this.footer = document.querySelector('.site-footer');
    this.updateNaturalOffset();
    this.onScroll = this.check.bind(this);
    this.onResize = this.handleResize.bind(this);
    window.addEventListener('scroll', this.onScroll, { passive: true });
    window.addEventListener('resize', this.onResize);
    window.addEventListener('touchmove', this.onScroll, { passive: true });
    setInterval(this.onScroll, 250);
    this.check();
  }
  FloatingCtaVisibility.mount = function () {
    var el = document.querySelector('.floating-cta');
    if (!el) return null;
    return new FloatingCtaVisibility(el);
  };
  FloatingCtaVisibility.prototype.updateNaturalOffset = function () {
    var prevPos = this.el.style.position, prevBottom = this.el.style.bottom;
    this.el.style.position = '';
    this.el.style.bottom = '';
    this.naturalBottomOffset = parseFloat(getComputedStyle(this.el).bottom) || 20;
    this.el.style.position = prevPos;
    this.el.style.bottom = prevBottom;
  };
  FloatingCtaVisibility.prototype.handleResize = function () {
    this.updateNaturalOffset();
    this.check();
  };
  FloatingCtaVisibility.prototype.check = function () {
    var heroBottom = this.hero ? (this.hero.getBoundingClientRect().bottom + window.pageYOffset) : 10;
    var nav = document.getElementById('site-nav');
    var navHeight = nav ? nav.getBoundingClientRect().height : 0;
    var scrollY = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || 0;
    this.el.classList.toggle('is-visible', scrollY > heroBottom - navHeight);

    if (this.footer) {
      var margin = 20;
      var bottomOffset = this.naturalBottomOffset;
      var ctaHeight = this.el.offsetHeight;
      var footerTopInDoc = this.footer.getBoundingClientRect().top + window.pageYOffset;
      var viewportBottomInDoc = window.pageYOffset + window.innerHeight;
      var fixedCtaTopInDoc = viewportBottomInDoc - bottomOffset - ctaHeight;

      if (fixedCtaTopInDoc + ctaHeight + margin > footerTopInDoc) {
        this.el.style.position = 'absolute';
        this.el.style.top = (footerTopInDoc - margin - ctaHeight) + 'px';
        this.el.style.bottom = 'auto';
      } else {
        this.el.style.position = '';
        this.el.style.top = '';
        this.el.style.bottom = '';
      }
    }
  };

  /* ===================================================================
     Bootstrap
     =================================================================== */
  (function detectFlexGap() {
    try {
      var f = document.createElement('div');
      f.style.cssText = 'display:flex;flex-direction:column;row-gap:1px;position:absolute;visibility:hidden';
      f.appendChild(document.createElement('div'));
      f.appendChild(document.createElement('div'));
      document.body.appendChild(f);
      var supported = f.scrollHeight === 1;
      document.body.removeChild(f);
      if (!supported) document.documentElement.className += ' no-flexgap';
    } catch (e) {}
  })();

  /* ServiceAccordion */
  function ServiceAccordion(root) {
    this.root = root;
    this.headers = Array.prototype.slice.call(root.querySelectorAll('.service-card__header'));
    this.onClick = this.onClick.bind(this);
    this.onKey = this.onKey.bind(this);
    this.onDocClick = this.onDocClick.bind(this);
    this.headers.forEach(function (header) {
      header.addEventListener('click', this.onClick);
      var card = header.closest('.service-card');
      if (card) card.addEventListener('keydown', this.onKey);
    }, this);
    document.addEventListener('click', this.onDocClick);
  }
  ServiceAccordion.prototype.toggle = function (card) {
    if (!card || card.classList.contains('service-card--featured')) return;
    var alreadyOpen = card.classList.contains('is-open');
    var open = this.root.querySelector('.service-card.is-open');
    if (open) open.classList.remove('is-open');
    if (!alreadyOpen) card.classList.add('is-open');
  };
  ServiceAccordion.prototype.onClick = function (e) {
    this.toggle(e.currentTarget.closest('.service-card'));
  };
  ServiceAccordion.prototype.onKey = function (e) {
    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.toggle(e.currentTarget); }
  };
  ServiceAccordion.prototype.onDocClick = function (e) {
    var open = this.root.querySelector('.service-card.is-open');
    if (open && !open.contains(e.target)) open.classList.remove('is-open');
  };
  ServiceAccordion.mount = function () {
    var root = document.querySelector('[data-service-accordion]');
    if (!root) return null;
    return new ServiceAccordion(root);
  };

  /* AuroraMotion */
  function AuroraMotion(stage) {
    this.stage = stage;
    this.layers = [
      { el: stage.querySelector('.aurora-a'), rx: 26, ry: 22, speed: 0.00021, phase: 0,       mouse: 0.05 },
      { el: stage.querySelector('.aurora-b'), rx: 30, ry: 26, speed: 0.00016, phase: 2.4,     mouse: 0.08 },
      { el: stage.querySelector('.aurora-c'), rx: 20, ry: 30, speed: 0.00027, phase: 4.2,     mouse: -0.06 }
    ].filter(function (l) { return !!l.el; });
    this.mx = 0; this.my = 0;
    this.raf = null;
    this.onMove = this.onMove.bind(this);
    this.tick = this.tick.bind(this);
  }
  AuroraMotion.prototype.onMove = function (e) {
    var r = this.stage.getBoundingClientRect();
    this.mx = ((e.clientX - r.left) / r.width - 0.5) * 2;
    this.my = ((e.clientY - r.top) / r.height - 0.5) * 2;
  };
  AuroraMotion.prototype.tick = function (t) {
    for (var i = 0; i < this.layers.length; i++) {
      var l = this.layers[i];
      var ang = t * l.speed + l.phase;
      var x = Math.cos(ang) * l.rx + this.mx * l.rx * l.mouse * 4;
      var y = Math.sin(ang * 1.3) * l.ry + this.my * l.ry * l.mouse * 4;
      var scale = 1 + Math.sin(ang * 0.8) * 0.12;
      l.el.style.transform = 'translate(' + x.toFixed(2) + '%, ' + y.toFixed(2) + '%) scale(' + scale.toFixed(3) + ')';
    }
    this.raf = requestAnimationFrame(this.tick);
  };
  AuroraMotion.mount = function () {
    var stage = document.querySelector('[data-hero-stage]');
    if (!stage) return null;
    var motion = new AuroraMotion(stage);
    if (!motion.layers.length) return null;
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return null;
    stage.addEventListener('mousemove', motion.onMove);
    motion.raf = requestAnimationFrame(motion.tick);
    return motion;
  };

  try { HeroSignature.mount(); } catch (e) {}
  try { AuroraMotion.mount(); } catch (e) {}
  try { ScrollReveal.mount(); } catch (e) {}
  try { Navigation.mount(); } catch (e) {}
  try { PriorityNav.mount(); } catch (e) {}
  try { ContactPanel.mount(); } catch (e) {}

  function HeroCredsClearance() {
    var stage = document.querySelector('[data-hero-stage]');
    var credsBar = document.querySelector('.creds-bar');
    if (!stage || !credsBar) return;
    var MOBILE_BP = 767;
    var CREDS_TEXT_GAP = 8;
    function run() {
      if (window.innerWidth > MOBILE_BP) { stage.style.paddingBottom = ''; return; }
      stage.style.paddingBottom = (credsBar.offsetHeight + CREDS_TEXT_GAP) + 'px';
    }
    run();
    window.addEventListener('resize', run);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(run);
  }

  try { FloatingCtaVisibility.mount(); } catch (e) {}

  function FooterBackToTopAlign() {
    var footer = document.querySelector('.site-footer');
    var btn = document.getElementById('back-to-top');
    var creditRow = document.querySelector('.site-footer__credit');
    if (!footer || !btn || !creditRow) return;
    function run() {
      var footerRect = footer.getBoundingClientRect();
      var creditRect = creditRow.getBoundingClientRect();
      var creditCenterFromFooterBottom = footerRect.height - (creditRect.top - footerRect.top) - (creditRect.height / 2);
      btn.style.bottom = (creditCenterFromFooterBottom - (btn.offsetHeight / 2)) + 'px';
    }
    run();
    window.addEventListener('resize', run);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(run);
  }

  try { HeroCredsClearance(); } catch (e) {}
  try { FooterBackToTopAlign(); } catch (e) {}

  /* ReferralParallax */
  (function () {
    var sections = document.querySelectorAll('.referral-section');
    if (!sections.length) return;
    var instances = [];
    sections.forEach(function (section) {
      var photo = section.querySelector('.referral-section__bg-photo');
      if (photo) instances.push({ section: section, photo: photo });
    });
    if (!instances.length) return;
    var ticking = false;
    function update() {
      ticking = false;
      var vh = window.innerHeight || document.documentElement.clientHeight;
      instances.forEach(function (inst) {
        var rect = inst.section.getBoundingClientRect();
        var progress = (vh - rect.top) / (vh + rect.height);
        progress = Math.max(0, Math.min(1, progress));
        var shift = (progress - 0.5) * 12;
        inst.photo.style.transform = 'translateX(-50%) translateX(' + shift.toFixed(2) + '%)';
      });
    }
    function onScroll() {
      if (!ticking) { ticking = true; requestAnimationFrame(update); }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    update();
  })();

  try { ServiceAccordion.mount(); } catch (e) {}

  /* NdisSealAlign */
  (function () {
    var wrap = document.querySelector('.services-intro-row .floating-cta__ndis-wrap');
    var row = document.querySelector('.services-intro-row');
    var heading = row && row.querySelector('.text-heading');
    var desc = row && row.querySelector('.blog-header__desc');
    if (!wrap || !row || !heading || !desc) return;
    function position() {
      var rowTop = row.getBoundingClientRect().top;
      var hRect = heading.getBoundingClientRect();
      var isDesktop = window.innerWidth >= 768;
      var centre = isDesktop
        ? (hRect.top + desc.getBoundingClientRect().bottom) / 2
        : (hRect.top + hRect.bottom) / 2;
      var wrapHeight = wrap.getBoundingClientRect().height;
      var nudge = isDesktop ? -20 : 0;
      wrap.style.top = (centre - rowTop - wrapHeight / 2 + nudge) + 'px';
    }
    position();
    window.addEventListener('resize', position);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(position);
    if (window.ResizeObserver) {
      var ro = new ResizeObserver(position);
      ro.observe(row); ro.observe(heading); ro.observe(desc);
    }
    window.addEventListener('load', position);
  })();

  /* Back-to-top */
  (function () {
    var btn = document.getElementById('back-to-top');
    if (!btn) return;
    btn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  })();

  /* Footer phone card — tappable on mobile */
  (function () {
    var phone = document.querySelector('.footer-phone');
    var icon = document.querySelector('.footer-phone__icon');
    if (!phone || !icon) return;
    phone.addEventListener('click', function (e) {
      if (window.innerWidth > 767) return;
      if (e.target.closest && e.target.closest('.footer-phone__icon')) return;
      window.location.href = icon.getAttribute('href');
    });
  })();

  document.documentElement.setAttribute('data-js-booted', '1');

  /* FAQ page — tab click filters the flat Q&A list by data-faq-cat, each row's question toggles its own answer open/closed */
  (function () {
    var tabs = document.querySelector('[data-faq-tabs]');
    if (!tabs) return;
    var rows = document.querySelectorAll('.faq-row');
    tabs.addEventListener('click', function (e) {
      var btn = e.target.closest('[data-faq-tab]');
      if (!btn) return;
      tabs.querySelectorAll('.faq-tab').forEach(function (t) { t.classList.remove('is-active'); });
      btn.classList.add('is-active');
      var cat = btn.getAttribute('data-faq-tab');
      rows.forEach(function (row) {
        row.hidden = row.getAttribute('data-faq-cat') !== cat;
        row.classList.remove('is-open');
      });
    });
    rows.forEach(function (row) {
      var q = row.querySelector('[data-faq-toggle]');
      if (q) q.addEventListener('click', function () { row.classList.toggle('is-open'); });
    });
  })();

  /* ===================================================================
     Blog search — debounced AJAX search across every published post
     (not just the current page's 9), rendered as a compact dropdown
     of small-thumbnail + title results.
     =================================================================== */
  (function () {
    var input = document.getElementById('blog-search');
    var results = document.getElementById('blog-search-results');
    if (!input || !results || typeof SheehanConfig === 'undefined') return;
    var debounceTimer, activeRequest;

    function render(items) {
      if (!items.length) {
        results.innerHTML = '<div class="blog-search-results__empty">No articles match your search.</div>';
        results.hidden = false;
        return;
      }
      results.innerHTML = items.map(function (item) {
        var thumbStyle = item.thumbnail ? 'background-image:url(\'' + item.thumbnail + '\')' : '';
        return '<a class="blog-search-results__item" href="' + item.permalink + '">' +
          '<span class="blog-search-results__thumb" style="' + thumbStyle + '"></span>' +
          '<span class="blog-search-results__title">' + item.title + '</span></a>';
      }).join('');
      results.hidden = false;
    }

    input.addEventListener('input', function () {
      var term = input.value.trim();
      clearTimeout(debounceTimer);
      if (!term) { results.hidden = true; results.innerHTML = ''; return; }
      results.innerHTML = '<div class="blog-search-results__loading">Searching…</div>';
      results.hidden = false;
      debounceTimer = setTimeout(function () {
        if (activeRequest) activeRequest.abort();
        activeRequest = new AbortController();
        var url = SheehanConfig.ajaxUrl + '?action=sheehan_blog_search&term=' + encodeURIComponent(term) +
          '&_wpnonce=' + encodeURIComponent(SheehanConfig.blogSearchNonce);
        fetch(url, { signal: activeRequest.signal })
          .then(function (r) { return r.json(); })
          .then(function (data) { render((data && data.data) || []); })
          .catch(function () {});
      }, 200);
    });

    document.addEventListener('click', function (e) {
      if (!results.contains(e.target) && e.target !== input) results.hidden = true;
    });
  })();
})();
