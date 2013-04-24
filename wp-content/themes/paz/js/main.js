/**
 * Main Application Object
 *
 * @type object
 */
var PAZ = PAZ || { } ;
/**
 * The History Module handles the content ajax requests.
 *
 * @type Object
 */
/**
 * The History Module handles the content ajax requests.
 *
 * @type Object
 */
PAZ.history = ( function () {

  var history = { } ;

  /**
   * Stores functions for applying when the module has
   * completed a content loading request.
   */
  history.events = { } ;

  /**
   * Initializes the History Module.
   *
   * @returns {undefined}
   */
  history.initialize = function () {
    if ( ! history.hasPushState () ) {
      return ;
    }

    // stablished the content holding DOM Element
    history.element = $ ( 'content' ) ;
    history.scroll = new Fx.Scroll ( document.body ) ;

    if ( history.element ) {
      history.createRequestObject () ;
      history.addEventHandlers () ;
      history.addPopStateHandler () ;

      history.fireEvent ( 'complete' ) ;
      history.pushState( window.location.href);
    }
  } ;

  /**
   * Attaches the event listeners for specific history events.
   *
   * @returns {undefined}
   */
  history.addPopStateHandler = function ( ) {
    Element.NativeEvents.popstate = 2 ;
    $ ( window ).addEvent ( 'popstate', history.popStateHandler ) ;
  } ;

  /**
   * Handler the PopState event.
   *
   * @param {DOMEvent} event the PopState event.
   * @returns {undefined}
   */
  history.popStateHandler = function ( event ) {
    if (event.event.state &&  event.event.state.href) {
      history.request.send ( {
        url : event.event.state.href
      } ) ;
    }
  } ;

  /**
   * Adds an event handling function.
   *
   * @param {String} event the event name
   * @param {Function} handler the function to call when the event is fired
   * @returns {undefined}
   */
  history.addEvent = function ( event, handler ) {
    if ( typeOf ( history.events[ event ] ) !== 'array' ) {
      history.events[ event ] = [ ] ;
    }
    history.events[ event ].push ( handler ) ;
  } ;

  /**
   * Event handler for the Request.HTML.onSend event.
   *
   * @returns {undefined}
   */
  history.requestSend = function ( ) {
    history.scroll.toTop () ;
    history.element.spin () ;
    history.fireEvent ( 'send' ) ;
  } ;

  /**
   * Fires an event from the history object.
   *
   * @param {type} event
   * @returns {undefined}
   */
  history.fireEvent = function ( event ) {
    if ( typeOf ( history.events[ event ] ) === 'array' ) {
      history.events[ event ].each ( function ( handler ) {
        if ( typeOf ( handler ) === 'function' ) {
          handler.apply ( history.element ) ;
        }
      } ) ;
    }
  } ;

  /**
   * Event handler for the Request.HTML.onComplete event.
   *
   * @returns {undefined}
   */
  history.requestComplete = function ( ) {
    // update document.body from metadata DOMElement
    var bodyMetadata = history.element.getElement ( '#body-metadata' ) ;
    if ( bodyMetadata ) {
      $ ( document.body ).set ( 'class', bodyMetadata.get ( 'class' ) ) ;
      $ ( document ).title = bodyMetadata.get ( 'data-title' ) ;
    }

    history.fireEvent ( 'complete' ) ;
    history.element.get ( 'spinner' ).position () ;
    history.element.unspin () ;
  } ;

  /**
   * Initializes the Request.HTML instance that will be used
   * throught the aplication life.
   *
   * @returns {undefined}
   */
  history.createRequestObject = function ( ) {
    history.request = new Request.HTML ( {
      update : history.element,
      data : {
        ajax : 'ajax',
        action : 'load_content'
      },
      onRequest : history.requestSend,
      onComplete : history.requestComplete
    } ) ;
  } ;

  /**
   * Computes if the current browser supports the HTML5 History API.
   *
   * @returns {Boolean} <code>true</code> if the crouwser supports
   * the HTML5 History API and <code>false</code> otherwise.
   */
  history.hasPushState = function () {
    var windowHistory = window.history ;
    return ( 'pushState' in windowHistory ) ;
  } ;

  /**
   * Loads a specific address into the module's content element.
   *
   * @param {String} href the resource's URL
   * @returns {undefined}
   */
  history.loadContent = function ( href ) {
    history.pushState ( href ) ;
    history.request.send ( {
      url : href
    } ) ;
  } ;

  /**
   * Pushes the new state of the Application into the History stack.
   *
   * @param {String} href the address to show in the Browser's NavBar.
   * @param {Object} state the state to push to the history stack.
   * @returns {undefined}
   */
  history.pushState = function ( href, state ) {
    state = state || { } ;
    state.href = href ;
    window.history.pushState ( state, null, href ) ;
  } ;

  /**
   * Hadles the click event delegation for selected anchors.
   *
   * @param {DOMEvent} event the click event
   * @param {Element} target the clicked element
   * @returns {undefined}
   */
  history.clickEventHandler = function ( event, target ) {
    var href = target.get ( 'href' ),
      uri = new URI( href ) ;
    //uri.setData ( 'lan', $ ( document.body ).get ( 'data-language' ).substr ( 0, 2 ) ) ;
    history.loadContent ( uri.toString () ) ;
    event.stop () ;

  } ;

  /**
   * Attached the event listeners for specific anchor elements.
   *
   * @returns {undefined}
   */
  history.addEventHandlers = function () {
    var not = '.language-link, [target=_blank], [href^=' + Server.url.admin + '], [href^=' + Server.url.login + ']',
      relay = 'a[href^=' + Server.url.site + ']:not(' + not + ')',
      selector = 'click:relay(' + relay + ')' ;
    $ ( document.body ).addEvent ( selector, history.clickEventHandler ) ;
  } ;

  // star the mdule on domreacy event
  $ ( window ).addEvent ( 'domready', history.initialize ) ;

  // return the public interface
  return history ;

} ( ) ) ;

$ ( window ).addEvent ( 'domready',
  function () {
    new Fx.SmoothScroll({
      duration: 200
    },window);

    $ ( document.body ).addEvent('click:relay(.filter-proyects)', function( event, target) {

      var tax = target.get( 'data-tax'),
      thmb = $( 'template-container' ),
      request = new Request.HTML({
        url: Server.url.ajax,
        update: thmb,
        data: {
          action:'my_action',
          taxonomy: tax
        },
        onRequest:function(){
           thmb.spin();
        },
        onComplete:function(){
           thmb.unspin();
        }
      });
      event.stop();
      request.send();
    } );
  }
);

