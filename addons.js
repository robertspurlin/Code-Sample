/*
 ** addons.js
 ** Author: Robert Spurlin 
 ** Link: https://vessel.titaninswebsites.com
 ** Vessel Insurance Template - the JS for the navigation animations, and a little extra. 
 */

"use strict";

// The container (#titan-nav)'s width. Used to determine how far the links will have to go
const linkcontainer = document.getElementById("titan_nav").offsetWidth;

// The actual links themselves. Stored in a list.
// NOTE: Lists respond to array methods, but are not the same.
const navlinks = document.querySelectorAll("#titan_nav .menu-item");

// The button that shows up when you scroll down
const trigger = document.getElementById("desktoptrigger");

// The entire nav itself
const navbar = document.getElementById("nav");

// Helper booleans 
let done, clicked = false;

// On scroll...
window.addEventListener('scroll', () => {

  // console.log('scrolled');

  // If the user scrolls and hasn't scrolled down before (!done)
  if (window.scrollY !== 0 && !done) {

    // Iterate through the link list
    navlinks.forEach((link) => {

      // There is no DOM property that returns the "Offset Right" of an element, relative
      // to it's container. getItemOffset returns the "Offset Right" by subtracting the 
      // width of the container that the link is in from both the offsetLeft and the
      // overall width of the link itself. 
      // So: distance = widthOfContainer - (offsetLeftOfLink + offsetWidthOfLink).
      const distance = getItemOffset(link, linkcontainer);

      // For every link in the nav, move it over to the farthest right of the container
      link.style.transform = "translateX(" + distance + "px)";

      // And make the links dissapear while we are at it
      link.className += " menuhide";

      // End of forEach loop
    });

    // Have to do the same thing for the button that appears because it appears and
    // moves with the links
    const triggeroffset = getItemOffset(trigger, linkcontainer);

    // Captain, permission to move the button where it should be?
    // "Make it so"
    trigger.style.transform = "translateX(" + triggeroffset + "px)";

    // Have to show the button. What good is a button if you don't show it?
    trigger.className += " dtshow";

    // If the nav wasn't transparent before, make it transparent 
    if (!navbar.classList.contains("transparentnav")) {
      navbar.classList.toggle("transparentnav");
    }

    // Make sure that when we continue scrolling, the nav doesn't do the animation again..
    done = true;

    // else if the user has reached the bottom of the page OR top of the page
  } else if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight || window.scrollY == 0) {

    // Iterate through the list again 
    navlinks.forEach((link) => {

      // Make the links appear again
      if (link.classList.contains("menuhide")) {
        link.classList.toggle("menuhide");
      }

      // And move them back to their original positions 
      link.style.transform = "translateX(0px)";

      // End of forEach loop
    });

    // Turn on the listener, so when the user scrolls up or down again, do the pretty animation 
    done = false;

    // Hide the button when the top or bottom of page is reached.. 
    if (trigger.classList.contains("dtshow")) {
      trigger.classList.toggle("dtshow");
    }

    // and move it back to complete the animation. Looks good when the links are moving with it.
    trigger.style.transform = "translateX(0px)";

    // Only if the user has reached the bottom, make the nav NOT transparent
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
      navbar.classList.toggle("transparentnav");
    }

    // else if the button has been clicked before the user scrolls
  } else if (clicked) {

    // put the button back in it's original place 
    const triggeroffset = getItemOffset(trigger, linkcontainer);
    trigger.style.transform = "translateX(" + triggeroffset + "px)";

    // and make sure that this doesn't go off until the button is clicked again.
    clicked = false;

    // NOTE: Do not need to iterate through the links again because window.addEventListener('scroll')
    // runs thousands of times. EXTREMELY unlikely that the user scrolls such a little amount that
    // window.addEventListener('scroll') only runs once. So this else if statement will run, and 
    // immediately after, the first if statement will run, moving the links to their proper place.
    // The test: uncommenting the console.log on the start of the scroll event listener.
    // Hint: I did, and gave up shortly after. Will most likely run hundreds of times no matter how
    // little you scroll. 
  }

  // End of window.addEventListener('scroll')
});


// When the button is both showing and is clicked
trigger.addEventListener("click", () => {

  // Iterate through the links again
  navlinks.forEach((link) => {

    // Show the links
    link.classList.toggle("menuhide");

    // And move them to their proper places
    link.style.transform = "translateX(0px)";
  });

  // Hide the button
  trigger.classList.toggle("dtshow");

  // And move it over to complete the animation
  trigger.style.transform = "translateX(0px)";

  // Make the nav not transparent 
  navbar.classList.toggle("transparentnav");

  // Turn on the clicked listener for the last else if statement above,
  clicked = true;

  // And turn off the scroll listener, making the nav ready to do the animation again on scroll. 
  done = false;
});

// returns offsetRight of element. See explanation in the first if statement in the scroll event listener

function getItemOffset(x, y) {
  return y - (x.offsetLeft + x.offsetWidth);
}

// On internal insurance sites (specific, ex: Life), determines the height on the container that is on top of the graybg
// behind it. Creates the floating effect, and is reusable no matter how much content is in those boxes.

function height() {

  // The container below the first (the graybg). If it exists, great. Else, null.
  // Tertiary statement needed because is assigning the offsetHeight.
  // If it doesn't exist, then it obviously doesn't have an offsetHeight. 
  const undercontainer = document.getElementById("parent") ? document.getElementById("parent").offsetHeight : null;

  // This one is just selecting the container in question
  const topcontainer = document.getElementById('child');

  // Do they both actually exist?
  if (topcontainer && undercontainer) {

    // Great! Make the height equal
    topcontainer.style.height = undercontainer + "px";

    // And make it that they are on top of each other. 
    topcontainer.style.marginTop = -undercontainer + "px";
  }
}

// Button ripple effect. Credit where it's due:
// http://thecodeplayer.com/walkthrough/ripple-click-effect-google-material-design
// NOTE: Was trying to not use jQuery when I was making the navigation. 
// That's why document.ready is down here...
// Also: function() instead of arrow is needed here due to this being referenced. 
// With arrow functions and 'use strict', the this keyword is ignored. 

jQuery(document).ready(function ($) {

  // This is my only addition. Make sure that the function above actually runs. 
  height();

  let element, circle, d, x, y;
  $(".abutton").click(function (e) {

    element = $(this);

    if (element.find(".circle").length == 0)
      element.prepend("<span class='circle'></span>");

    circle = element.find(".circle");
    circle.removeClass("animate");

    if (!circle.height() && !circle.width()) {
      d = Math.max(element.outerWidth(), element.outerHeight());
      circle.css({
        height: d,
        width: d
      });
    }

    x = e.pageX - element.offset().left - circle.width() / 2;
    y = e.pageY - element.offset().top - circle.height() / 2;

    circle.css({
      top: y + 'px',
      left: x + 'px'
    }).addClass("animate");
  });

  // End button ripple effect. Note: still in (document).ready

  // Makes the nav open and close on mobile. Was in a header <script> element, thought it would 
  // be best to move it here..

  $('.navbar-toggler').click(function () {
    $(this).toggleClass('closenav opennav');

    $('.navbar-collapse').toggleClass('open');
  });

  // Smooth scroll function.
  // NOTE: not my function, just the same one that I keep using from site to site. 

  $('a[href*="#"]:not([href="#"]):not(.abutton.nav-link)').click(function () {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      var targetscroll = target.offset().top;
      if (target.length) {
        $('html, body').animate({
          scrollTop: targetscroll
        }, 500);
        return false;
      }
    }
  });

  // These two functions are when clients want to use the staff boxes plugin.
  // They just make the bootstrap modals agree with the footer parallax
  // effect.

  $("body").on('click', '.staff-box', () => {
    $('body').addClass('p-0');
    $('#primary').addClass('normal');
    $("#realfooter").addClass('normal');
  });

  $("body").on('click', 'button.close', () => {
    $('body').removeClass('p-0');
    $('#primary').removeClass('normal');
    $("#realfooter").removeClass('normal');
  });

  // This is what makes the footer parallax work. Adds bottom padding
  // to body to make sure that it appears accordingly

  $("body").css({
    'padding-bottom': $("#realfooter").outerHeight()
  });

  // Makes sure that everything is correct when resizing window
  $(window).resize(() => {

    // Just to make sure if user is in internal sites, 
    // adjust the floating containers appropriately. 
    height();

    // Just to make sure nothing funny happens on window resize
    // with the parallax
    $("body").css({
      'padding-bottom': $("#realfooter").outerHeight()
    });
  });

  // This toggles another class for the fade effects on click of the button for the nav. It is down here because
  // jQuery. Was just easier to call this than use regular JS. 
  $('#desktoptrigger').click(() => {
    $('#desktoptrigger').toggleClass('closenav opennav');
  });

  // end of (document).ready
});