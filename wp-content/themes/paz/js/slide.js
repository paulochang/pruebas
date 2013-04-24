
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
        item.set('tween', {
          duration: 'normal', 
          transition: Fx.Transitions.Quad.easeInOut
        });
        if( item.complete ) {
          console.log('completo');
          self.imageLoadEventHandler();
        } else {
          console.log('evento');
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

      if ( this.length == 2 ) {
        this.prevBtn.addClass('one-display');
      }

      this.selectors = this.element.getElements ( this.options.selectors.selectors ) ;


      this.attachNavigationEvents();
      this.attachSelectorEvents();
      this.attachHomeEvent();

      this.current = this.computeIndex(-2) ;
      this.display(-1);

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
                self.next();  
                (function(){                 
                  self.show ( imageindex ) 
                }).delay(800) ;
              } else {
                self.show ( imageindex );
              }

              self.show ( imageindex ) ;
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
        self.homeEventHandler();
      });
    },

    /**
     * Handle home event
     *
     * @returns {undefined}
     */

    homeEventHandler : function () {      
        var p=this.element;
        this.display(-1);

          if (p.hasClass('closed')) {
            p.removeClass('closed');
            p.addClass('opened');
            this.updateSelectors(this.computeIndex(this.current));
          }
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
        this.goForward();
      }
    },
    /**
     * Display the previous slide.
     *
     * @returns {undefined}
     */
    prev : function () {
      this.goBackwards();
    },
    /**
     * Display the previous slide.
     *
     * @returns {undefined}
     */
    updateSelectors : function (index) {
      var newSlide = this.images[index];

      this.element.getElements('.selected-project').removeClass('selected-project');

      if ( newSlide ) {
        var foundIndex = false;

        if (this.element.hasClass('closed')) {
          this.selectors.each ( function ( selector, selectorIndex ) {
            if ((!foundIndex)&&(selector.get('data-slug')==newSlide.get('data-type'))) {
              foundIndex = true;
              selector.addClass('selected-project');
            }
          });
        } else {
          this.homeBtn.addClass('selected-project');
        }
      }
    },
    /**
     * Does forward animation
     *
     * @returns {undefined}
     */
    goForward : function () {

      var currentSlide = this.images[this.current],
      newSlide = this.images[this.computeIndex(this.current+1)],
      previousSlide = this.images[this.computeIndex(this.current-1)],
      nextSlide = this.images[this.computeIndex(this.current+2)];

      this.updateSelectors(this.computeIndex(this.current+1));
     

      this.current = this.computeIndex(this.current+1);

      //actual pasa a ser el anterior
      currentSlide.addClass('previous-slide');
      currentSlide.removeClass('shown-slide');

      //el nuevo pasa a ser el actual
      newSlide.setStyle('opacity', 1);
      newSlide.addClass('shown-slide');
      newSlide.removeClass('next-slide');

      //el anterior desaparece
      previousSlide.setStyle('opacity', 0);
      previousSlide.removeClass('previous-slide');

      //el siguiente se posiciona donde debe
      if (this.length!=2) nextSlide.removeClass('transition-margin-left');
      nextSlide.addClass('outer-slide');
      (function() {
        if (this.length!=2) nextSlide.addClass('transition-margin-left');
        nextSlide.removeClass('outer-slide');
        nextSlide.addClass('next-slide');
         nextSlide.setStyle('opacity', 1);
      }).delay(0);


      newSlide.setStyle('opacity', 1);

    },
    /**
     * Does backward animation
     *
     * @returns {undefined}
     */
    goBackwards : function () {

      var currentSlide = this.images[this.current],
      newSlide = this.images[this.computeIndex(this.current-1)],
      previousSlide = this.images[this.computeIndex(this.current-2)],
      nextSlide = this.images[this.computeIndex(this.current+1)];

      this.updateSelectors(this.computeIndex(this.current-1));


      this.current = this.computeIndex(this.current-1);

      //actual pasa a ser el siguiente
      currentSlide.setStyle('opacity', 1)
      currentSlide.addClass('next-slide');
      currentSlide.removeClass('shown-slide');

      //el nuevo pasa a ser el actual
      newSlide.setStyle('opacity', 1);
      newSlide.addClass('shown-slide');
      newSlide.removeClass('previous-slide');

      //el que iba a ser el siguiente desaparece]
      nextSlide.addClass('outer-slide');
      (function() {
        nextSlide.removeClass('outer-slide');
        nextSlide.setStyle('opacity', 0);
        nextSlide.removeClass('next-slide');
          //el que va antes del nuevo es ahora el previo
        previousSlide.removeClass('next-slide');
        previousSlide.removeClass('previous-slide');   
        previousSlide.setStyle('opacity', 0);
        previousSlide.addClass('previous-slide');
      }).delay(200);
    },
    /**
     * Display the slide in the selected index.
     *
     * @param {Number} index the slide's index.
     * @returns {undefined}
     */
    show : function ( index ) {
      var currentSlide = this.images[this.current],
      currentNextSlide = this.images[this.computeIndex(this.current+1)],
      currentPreviousSlide = this.images[this.computeIndex(this.current-1)]
      newSlide = this.images[this.computeIndex(index)],
      calculatedNextSlide = this.images[this.computeIndex(index+1)],
      calculatedPreviousSlide = this.images[this.computeIndex(index-1)];

      this.updateSelectors(this.computeIndex(index));

      if (this.element.hasClass('opened')) this.goForward();

      if (newSlide != currentSlide) {
        if (calculatedPreviousSlide == currentSlide) {
          // if the currentSlide is the immediate successor to our newSlide just go back to previous
          this.goForward();
        } else if (calculatedNextSlide == currentSlide) {
          // if the currentSlide is the immediate predecessor to our newSlide just advance to next
          this.goBackwards();
          } else {
            /*****************************************************************************/
            /* if newSlide is unrelated to currentSlide, change nextSlide and go forward */
            /*****************************************************************************/
            
            
            this.current = this.computeIndex(index);
            // 1. the current next slide disappears
            currentNextSlide.removeClass('next-slide');
            currentNextSlide.addClass('outer-slide');
            newSlide.addClass('outer-slide');
            
            (function(){
              // 2. the newly selected slide appears on right
              newSlide.removeClass('outer-slide');
              newSlide.setStyle('opacity', '1');
              newSlide.addClass('next-slide');
              // the calculated next slide prepares itself to appear
              calculatedNextSlide.addClass('outer-slide');
            }).delay(200);

            (function(){
              // 3. current slide moves to left
              currentSlide.addClass('previous-slide');
              currentSlide.removeClass('shown-slide');
              // 4. the newly selected slide is now featured image
              newSlide.removeClass('next-slide'); 
              newSlide.addClass('shown-slide');              

              // 5. the calculated next slide appears on right
              calculatedNextSlide.setStyle('opacity', '1');
              calculatedNextSlide.removeClass('outer-slide');
              calculatedNextSlide.addClass('next-slide'); 
              calculatedPreviousSlide.setStyle('opacity', 0)       
              // 6. the calculated previous slide is now moved to previous position      
              calculatedPreviousSlide.addClass('previous-slide');
            }).delay(800);

            ( function() {
              // 7. reset current next slide               
              currentNextSlide.setStyle('opacity', '0');
              currentNextSlide.removeClass('outer-slide');
              // 8. reset current slide 
              currentSlide.setStyle('opacity', '0');
              currentSlide.removeClass('previous-slide');
              // 9. reset current previous slide
              currentPreviousSlide.setStyle('opacity', '0');
              currentPreviousSlide.removeClass('previous-slide');
              // 9. prepare previous slide              
            }).delay(1400);

            (function() {
              calculatedPreviousSlide.setStyle('opacity', '1');
            }).delay(2000);

          }
      } else {
        // if the currentSlide is also the newly selected slide, nothing happens
      }
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
        this.element.getElements('.next-slide').setStyle('opacity', '0');
        this.element.getElements('.next-slide').removeClass('next-slide');
        this.element.getElements('.previous-slide').setStyle('opacity', '0');
        this.element.getElements('.previous-slide').removeClass('previous-slide');

        this.images[this.computeIndex(index+1)].addClass('next-slide');

        this.images[this.computeIndex(index-1)].addClass('previous-slide');
       if ( currentSlide ) {
         currentSlide.removeClass ( 'shown-slide' ) ;
         currentSlide.setStyle('opacity', '0');
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
        currentSlide.setStyle('opacity', '1');
        currentSlide.addClass('shown-slide') ;

        this.images[this.computeIndex(index+1)].setStyle('opacity', '1');
        this.images[this.computeIndex(index-1)].setStyle('opacity', '1');
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


