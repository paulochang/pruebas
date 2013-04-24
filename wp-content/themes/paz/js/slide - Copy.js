
/**
 * Main Application Object
 *
 * @type object
 */
var PAZ = PAZ || { } ;

/**
 *
 *
 * @type Class
 */
PAZ.Gallery = ( function () {

  /**
   * This module's namespace object.
   *
   * @type Class
   */
  var gallery = new Class ( {
    Implements : [ Options ],
    /**
     * The container element.
     */
    element : false,
    /**
     * The currently active slide.
     */
    current : 0,
    /**
     * This Gallery options.
     */
    options : {
      selectors : {
        images : 'img.slide',
        nextBtn: '.next-arrow',
        prevBtn: '.prev-arrow',
        homeBtn: '.home-selector',
        selectors : 'li.selector'
      }
    },
    /**
     * Class Constructor
     *
     * @param {Element} element
     * @param {Object} options
     * @returns {PAZ.Gallery}
     */
    initialize : function ( element, options ) {
      var self = this;
      this.element = $ ( element ) ;
      this.setOptions ( options ) ;

      this.images = this.element.getElements ( this.options.selectors.images ) ;
      this.length = this.images.length ;
      this.loadedImages = 0;

      this.element.addClass ( 'loading' );
      this.element.spin();
      this.images.each( function( item ) {
        if( item.complete ) {
          self.imageLoadEventHandler();
        } else {
          item.addEvent ( 'load', function () {
              self.imageLoadEventHandler ();
          } );
        }
      });
      this.nextBtn = this.element.getElement( this.options.selectors.nextBtn);
      this.prevBtn = this.element.getElement( this.options.selectors.prevBtn);
      this.homeBtn = this.element.getElement( this.options.selectors.homeBtn);

      if ( this.length <= 0 ) {
        return ;
      }

      if ( this.length == 1 ) {
        this.nextBtn.addClass('one-display');
        this.prevBtn.addClass('one-display');
      }

      this.selectors = this.element.getElements ( this.options.selectors.selectors ) ;


      this.attachNavigationEvents();
      this.attachSelectorEvents();
      this.attachHomeEvent();

      this.current = -1 ;
      this.display ( -1 );

      gallery.galleries.push ( this ) ;
    },
    /**
     * Adds and event for next/previous button.
     *
     * @returns {undefined}
     */

    attachNavigationEvents : function () {
      var self = this,
        length = self.length ;

      this.element.addEvent( 'click:relay(' +  this.options.selectors.nextBtn + ')', function( event, target) {
        self.next();
        event.stop();
      } );

      this.element.addEvent( 'click:relay(' +  this.options.selectors.prevBtn + ')', function( event, target) {
        self.prev();
        event.stop();
      } );

    },
    /**
     * Adds and event for each Selector.
     *
     * @returns {undefined}
     */
    attachSelectorEvents : function () {
      var self = this,
        foundIndex = false,
        imageArray = this.images,
        p=this.element;

      this.selectors.each ( function ( selector, index ) {
        foundIndex = false;

        imageArray.each(function(image, imageindex){
          if ((!foundIndex)&&(selector.get('data-slug')==image.get('data-type'))) {
            foundIndex = true;
            selector.addEvent ( 'click', function ( event ) {
              if (p.hasClass('opened')) {
                p.removeClass('opened');
                p.addClass('closed');
              }
              self.display ( imageindex ) ;
              event.stop () ;
            } ); /* add selector event */
          } /* endIF */
        } ); /* imageArray cycle */

      } ); /* selectors cycle */

    },

    /**
     * Adds and event for home button.
     *
     * @returns {undefined}
     */

    attachHomeEvent : function () {
      var self = this,
        length = self.length,
        p=this.element;

     this.homeBtn.addEvent('click', function( event ){
      if (p.hasClass('closed')) {
        p.removeClass('closed');
        p.addClass('opened');
      }
        self.display ( -1 );
     } );

    },
    /**
     * Spins the images till last is loaded
     *
     * @param {type} index
     */
    imageLoadEventHandler : function () {
      var parent = this.element;
      this.loadedImages --;

      if ( this.loadedImages < 1 ) {
        parent.removeClass('loading');
        parent.unspin();
      }
    },
    /**
     * Check for the index bounds before displaying a Slide.
     *
     * @param {type} index
     */
    computeIndex : function ( index ) {
      var safeIndex = index ;

      if ( index < 0 ) {
        safeIndex = this.computeIndex ( this.length + index ) ;
      } else if ( index >= this.length ) {
        safeIndex = this.computeIndex ( index - this.length ) ;
      } else {
        safeIndex = index ;
      }

      return safeIndex ;

    },
    /**
     * Display the next slide.
     *
     * @returns {undefined}
     */
    next : function () {
      var p=this.element;

      if (p.hasClass('opened')) {
        p.removeClass('opened');
        p.addClass('closed');

      }
      if (p.hasClass('closed')) {
        this.display ( this.current + 1 ) ;
      }
    },
    /**
     * Display the previous slide.
     *
     * @returns {undefined}
     */
    prev : function () {
      this.display ( this.current - 1 ) ;
    },
    /**
     * Display the slide in the selected index.
     *
     * @param {Number} index the slide's index.
     * @returns {undefined}
     */
    display : function ( index ) {
      var currentSlide = this.images[this.current];
        this.element.getElements('.selected-project').removeClass('selected-project');
        this.element.getElements('.next-slide').removeClass('next-slide');
       if ( currentSlide ) {
         currentSlide.removeClass ( 'shown-slide' ) ;
       }

      this.current = this.computeIndex(index);

      currentSlide = this.images[this.current] ;

      if ( currentSlide ) {
        var foundIndex = false;

        if (this.element.hasClass('closed')) {
          this.selectors.each ( function ( selector, selectorIndex ) {
            if ((!foundIndex)&&(selector.get('data-slug')==currentSlide.get('data-type'))) {
              foundIndex = true;
              selector.addClass('selected-project');
            }
          });
        } else {
          this.homeBtn.addClass('selected-project');
        }
        currentSlide.addClass('shown-slide') ;
        this.images[this.computeIndex(index+1)].addClass('next-slide');
      }
    }
  } ) ;

  /**
   * Stores all Gallery instances.
   */
  gallery.galleries = [ ] ;

  /**
   * Stops all currently running Gallery instances. Must be called before
   * ajax-updating the site's content to avoid memory leaking
   * via periodical functions.
   *
   * @returns {undefined}
   */
  gallery.stopAll = function () {
    gallery.galleries.each ( function ( instance ) {
      instance.stop () ;
    } ) ;
  } ;

  return gallery ;

} () ) ;

$ ( window ).addEvent ( 'domready', function () {
  PAZ.history.addEvent ( 'complete', function () {

    new Fx.SmoothScroll({
      duration: 200
    },window);

  if ( $ ( 'project-content' ) ) {
    new PAZ.Gallery ( 'project-content' ) ;
  }
} ) ;
  if ( $ ( 'project-content' ) ) {
    new PAZ.Gallery ( 'project-content' ) ;
  }
} ) ;


