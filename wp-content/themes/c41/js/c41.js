/**
 * Extend Mootools Element Class
 * @type object
 */
Element.Events.hashchange = {
  onAdd : function () {
    var hash = self.location.hash ;

    var hashchange = function () {
      if ( hash === self.location.hash ) {
        return ;
      }

      hash = self.location.hash ;
      var value = ( hash.indexOf ( '#' ) === 0 ? hash.substr ( 1 ) : hash ),
        event = {value : value } ;

      $ ( window ).fireEvent ( 'hashchange', event ) ;
      $ ( document ).fireEvent ( 'hashchange', event ) ;
    } ;

    if ( "onhashchange" in window ) {
      $ ( window ).onhashchange = hashchange ;
    } else {
      hashchange.periodical ( 50 ) ;
    }
  }
} ;

/*
 * Initialize Google Analytics 
 */
var _gaq = _gaq || [ ] ;
_gaq.push ( [ '_setAccount', 'UA-37485931-1' ] ) ;
_gaq.push ( [ '_trackPageview' ] ) ;

( function () {
  var ga = document.createElement ( 'script' ) ;
  ga.type = 'text/javascript' ;
  ga.async = true ;
  ga.src = ( 'https:' == document.location.protocol ? 'https://ssl' : 'http://www' ) + '.google-analytics.com/ga.js' ;
  var s = document.getElementsByTagName ( 'script' )[0] ;
  s.parentNode.insertBefore ( ga, s ) ;
} ) () ;

/**
 * Main Application Namespace.
 * @type object
 */
var C41 = C41 || { } ;

C41 = ( function () {

  var c41 = { },
    loadResources = function () {
    c41.spinner = Asset.image ( Server.url.theme + '/images/spinner.gif' ) ;
  } ;

  c41.initialize = function () {
    loadResources ( ) ;
    c41.initializeScroll () ;

    c41.layout.initialize () ;
    c41.background.initialize () ;
    c41.social.initialize () ;
    c41.initializeFormSubmitDelegation () ;
    //c41.ajax.initialize () ;

    // fire events to force program startup
    $ ( window ).fireEvent ( 'resize' ) ;

    // fire the hash event for refreshing the page
    var hash = self.location.hash,
      value = ( hash.indexOf ( '#' ) === 0 ? hash.substr ( 1 ) : hash ),
      event = {value : value } ;
    if ( event.value.trim () !== '' ) {
      $ ( window ).fireEvent ( 'hashchange', event ) ;
    }
  } ;

  c41.initializeScroll = function () {
    c41.scroll = new Fx.Scroll ( window ) ;
  } ;

  c41.scrollToTop = function () {
    if ( c41.scroll ) {
      c41.scroll.toTop () ;
    }
  } ;

  c41.currentLanguage = function () {
    var body = $ ( document.body ),
      lan = body.get( 'data-language' ) || 'en-US' ;

    if ( lan.indexOf ( 'en' ) === 0 ) {
      lan = 'en' ;
    } else {
      lan = 'es' ;
    }

    return lan ;
  } ;

  c41.formSubmitDelegation = function ( event, target ) {
    var update = target.getNext ( '.form-update' ),
      action = target.get ( 'data-action' ), form ;

    form = new Form.Request ( target, update, {
      resetForm : false,
      requestOptions : {
        url : Server.url.ajax,
        method : 'post'
      },
      extraData : {
        action : action
      }
    } ) ;

    form.send () ;

    event.stop () ;
  } ;

  c41.initializeFormSubmitDelegation = function () {
    $ ( document.body ).addEvent ( 'submit:relay(form)', c41.formSubmitDelegation ) ;
  } ;

  c41.print = function ( message ) {
    if ( Server.debug ) {
      try {
        console.log ( '-- ' + message )
      }
      catch ( ex ) {
        // console not available
      }
    }
  } ;

  return c41 ;

} () ) ;

C41.Gallery = ( function () {

  var gallery = new Class ( {
    Implements : [ Options ],
    options : { },
    current : 0,
    initialize : function ( el, options ) {
      this.element = el ;
      this.setOptions ( options ) ;
      this.parseElement ( ) ;
      this.start () ;
    },
    start : function () {
      var self = this ;
      if ( self.timer ) {
        clearInterval ( self.timer ) ;
      }
      self.timer = ( function () {
        self.next () ;
      } ).periodical ( 5000 ) ;
    },
    parseElement : function ( ) {
      var self = this ;

      this.element.store ( 'gallery', this ) ;
      this.element.addClass ( 'parsed' ) ;
      this.images = this.element.getElements ( 'img.image' ) ;
      this.selectors = this.element.getElements ( '.selector' ) ;
      if ( this.images.length ) {
        this.images.set ( 'tween', { duration : 1500 } ) ;
        this.images.removeClass ( 'active' ).setStyle ( 'opacity', 0 ) ;
        this.images[0].addClass ( 'active' ).setStyle ( 'opacity', 1 ) ;

        this.selectors.removeClass ( 'active' ) ;
        this.selectors[0].addClass ( 'active' ) ;
      }

      this.selectors.each ( function ( item, index ) {
        item.addEvent ( 'click', function ( event ) {
          self.display ( index ) ;
          self.start () ;
          event.stop () ;
        } ) ;
      } ) ;

      this.element.addEvent ( 'click:relay(.next)', function ( event, target ) {
        event.stop () ;
        self.next () ;
        self.start () ;
      } ) ;

      this.element.addEvent ( 'click:relay(.prev)', function ( event, target ) {
        event.stop () ;
        self.prev () ;
        self.start () ;
      } ) ;
    },
    display : function ( index ) {
      var length = this.images.length,
        i = index ;

      if ( i < 0 ) {
        i = length + index ;
      } else if ( i >= length ) {
        i = index % length ;
      }

      this.images[this.current].removeClass ( 'active' ) ;
      this.images[i].addClass ( 'active' ) ;

      this.images[this.current].tween ( 'opacity', 1, 0 ) ;
      this.images[i].tween ( 'opacity', 0, 1 ) ;

      this.selectors[this.current].removeClass ( 'active' ) ;
      this.selectors[i].addClass ( 'active' ) ;

      this.current = i ;
    },
    next : function () {
      this.display ( this.current + 1 ) ;
    },
    prev : function () {
      this.display ( this.current - 1 ) ;
    }
  } ) ;

  gallery.parseAll = function ( element ) {
    var el = $ ( element ) || $ ( document.body ),
      unparsed = el.getElements( '.gallery:not(.parsed)' ) ;

    unparsed.each ( function ( item ) {
      new C41.Gallery ( item ) ;
    } ) ;

  } ;

  return gallery ;

} () ) ;

C41.social = ( function () {

  var social = { } ;

  social.initialize = function () {
    social.initializeFacebook () ;
  } ;

  social.parseSocialWidgets = function ( element ) {
    var el = element || $ ( document.body ) ;

    try {
      FB.XFBML.parse ( el ) ;
    } catch ( e ) {
    }
  } ;

  social.initializeFacebook = function () {
    ( function ( d, s, id ) {
      var js, fjs = d.getElementsByTagName( s )[0] ;
      if ( d.getElementById ( id ) )
        return ;
      js = d.createElement ( s ) ;
      js.id = id ;
      js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1" ;
      fjs.parentNode.insertBefore ( js, fjs ) ;
    } ( document, 'script', 'facebook-jssdk' ) ) ;
  } ;

  return social ;

} () ) ;

C41.ajax = ( function () {

  var ajax = { } ;

  ajax.initialize = function () {
    ajax.currentURI = self.location.href.replace ( self.location.hash, '' ) ;
    ajax.initializeElement () ;
    ajax.initializeAnchorDelegation () ;
    ajax.parseLoadedContent () ;
    $ ( window ).addEvent ( 'hashchange', ajax.hashChangeHandler ) ;
  } ;

  ajax.anchorDelegation = function ( event, target ) {
    var href = target.get ( 'href' ) || false,
      uri = new URI ( href ),
      url = uri.toString ( ),
      win = $ ( window ),
      path, comparable ;

    if ( target.hasClass ( 'language-en' ) || target.hasClass ( 'language-es' ) ) {
      uri = new URI ( $ ( window ).location.href ) ;
      uri.setData ( 'lan', target.hasClass ( 'language-en' ) ? 'en' : 'es' ) ;
      //console.log ( uri.toString () ) ;
      uri.go () ;
      event.stop () ;
    } else if ( ! href || url.indexOf ( Server.url.admin ) === 0 ) {
      return ;
    } else if ( url.indexOf ( Server.url.site ) === 0 ) {
      path = url.replace ( Server.url.home, '' ) ;
      comparable = win.location.hash.indexOf ( '#' ) === 0 ? win.location.hash.substr ( 1 ) : win.location.hash ;

      if ( comparable === path ) {
        ajax.hashChangeHandler ( { value : path } ) ;
      } else {
        win.location.hash = path ;
      }
      event.stop () ;
    }
  } ;

  ajax.initializeAnchorDelegation = function () {
    if ( ! Browser.ie ) {
      $ ( document.body ).addEvent ( 'click:relay(a:not(a[target="_blank"]))', ajax.anchorDelegation ) ;
    }
  } ;

  ajax.parseLoadedContent = function () {
    var bodyClassElement = ajax.element.getElement ( '.body-class' ),
      bodyClass = bodyClassElement? bodyClassElement.get( 'class' ).trim( ) : false ;

    if ( bodyClass ) {
      $ ( document.body ).set ( 'class', bodyClass ) ;
    }
    C41.social.parseSocialWidgets ( ajax.element ) ;
    C41.Gallery.parseAll ( ajax.element ) ;

    // refresh visual layout
    $ ( window ).fireEvent ( 'resize' ) ;
  } ;

  ajax.initializeElement = function ( ) {
    ajax.element = $ ( 'content-main' ) ;
    ajax.element.set ( 'load', {
      onRequest : function () {
        C41.scrollToTop () ;
        ajax.element.get ( 'spinner' ).position ().resize () ;
        ajax.element.spin () ;
      },
      onComplete : function () {
        ajax.parseLoadedContent () ;
        ajax.element.get ( 'spinner' ).position ().resize () ;
        ajax.element.unspin () ;
      }
    } ) ;
  } ;

  ajax.trackPageView = function ( path ) {
    if ( _gaq && _gaq.push ) {
      _gaq.push ( [ '_trackPageview', path ] ) ;
    }
  } ;

  ajax.hashChangeHandler = function ( event ) {
    var path = event.value.indexOf ( '/' ) === 0 ? event.value : '/' + event.value,
      url = Server.url.home + path,
      uri = new URI( url ) ;
    if ( ! uri.getData ( 'lan' ) ) {
      uri.setData ( 'lan', C41.currentLanguage () ) ;
    }
    ajax.currentURI = uri.toString () ;
    uri.setData ( 'ajax', 'ajax' ) ;
    C41.print ( uri.toString () ) ;
    ajax.element.load ( uri.toString () ) ;
    ajax.trackPageView ( path ) ;
  } ;

  return ajax ;

} () ) ;

C41.layout = ( function () {

  var layout = { } ;

  layout.initialize = function () {

    layout.blocks = { } ;
    layout.blocks.left = $ ( 'left-block' ) ;
    layout.blocks.right = $ ( 'right-block' ) ;
    layout.blocks.content = $ ( 'content-main' ) ;

    $ ( window ).addEvent ( 'resize', function () {
      layout.resizeContent () ;
      layout.resizeBlocks () ;
      layout.resizeArchiveLayout () ;
    } ) ;
  } ;

  layout.resizeContent = function () {
    var windowSize = $ ( window ).getSize (),
      width = Number.max( windowSize.x, 1024 ) - 400 ;
    layout.blocks.content.setStyle ( 'width', width + 'px' ) ;
  } ;

  layout.resizeBlocks = function () {
    var body = $ ( document.body ),
      windowSize = $ ( window ).getSize ( ) ;

    body[ windowSize.x < 1024 ? 'addClass' : 'removeClass' ] ( 'min-width' ) ;
    body[ windowSize.y < 768 ? 'addClass' : 'removeClass' ] ( 'min-height' ) ;
  } ;

  layout.resizeArchiveLayout = function () {
    var body = $ ( document.body ),
      contentSize = layout.blocks.content.getSize ( ) ;

    if ( body.hasClass ( 'min-height' ) || body.hasClass ( 'min-width' ) ) {
      layout.blocks.left.setStyle ( 'min-height', contentSize.y ) ;
      layout.blocks.right.setStyle ( 'min-height', contentSize.y ) ;
    } else {
      layout.blocks.left.setStyle ( 'min-height', 768 ) ;
      layout.blocks.right.setStyle ( 'min-height', 768 ) ;
    }
  } ;

  return layout ;

} () ) ;

C41.background = ( function () {

  var background = { },
    hasInitialized = false,
    hasLoaded = false ;

  background.initialize = function () {
    background.element = $ ( 'content-wrap' ) ;
    background.size = { } ;
    background.resize () ;
    background.fetchImage () ;
    $ ( window ).addEvent ( 'resize', function () {
      if ( $ ( document.body ).hasClass ( 'home' ) ) {
        background[ hasInitialized ? 'position' : 'fetchImage' ] () ;
      }
    } ) ;
  } ;

  background.fetchImage = function () {
    var style = background.element.getStyle ( 'background-image' ),
      url = style.replace( 'url(', '' ).replace( ')', '' ).replace( "'", '' ) ;

    if ( url === 'none' ) {
      return ;
    } else {
      hasInitialized = true ;
    }

    hasLoaded = false ;

    if ( Browser.ie ) {
      background.size.x = 1820 ;
      background.size.y = 1024 ;
      hasLoaded = true ;
    } else {
      background.element.addClass ( 'background-loading' ) ;
      background.asset = Asset.image ( url, {
        onLoad : function () {
          background.size = { } ;
          background.size.x = Number.from ( background.asset.get ( 'width' ) ) ;
          background.size.y = Number.from ( background.asset.get ( 'height' ) ) ;
          hasLoaded = true ;
          background.element.removeClass ( 'background-loading' ) ;
          background.position () ;
        }
      } ) ;
    }
  } ;

  background.resize = function () {
    var windowSize = $ ( window ).getSize ( ),
      y = Number.max ( windowSize.y, 768 ),
      x = Number.max( windowSize.x, 1024 ) - 400 ;



    background.element.setStyles ( {
      //'min-width' : x + 'px',
      'min-height' : y + 'px'
    } ) ;
  } ;

  background.position = function () {
    var assetSize = background.size,
      elementSize = background.element.getSize ( ),
      imageSize = { x : 0, y : 0 }, backgroundSize ;

    if ( hasLoaded === true ) {

      imageSize.x = elementSize.x ;
      imageSize.y = ( background.size.y * elementSize.x / assetSize.x ).toInt () ;

      if ( imageSize.y < elementSize.y ) {
        imageSize.y = elementSize.y ;
        imageSize.x = ( background.size.x * elementSize.y / assetSize.y ).toInt () ;
      }

      backgroundSize = imageSize.x + 'px ' + imageSize.y + 'px' ;
      background.element.setStyle ( 'background-size', backgroundSize ) ;
      background.resize () ;
    }
  } ;

  return background ;

} () ) ;


$ ( window ).addEvent ( 'domready', function () {

  C41.initialize () ;

} ) ;