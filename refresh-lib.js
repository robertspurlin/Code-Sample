/*
 **
 ** refresh-lib.js
 ** Author: Robert Spurlin
 ** 
 ** All the JS needed for the library website redesign.
 ** Refresh start: 10.1.2018
 ** link: https://library.mtsu.edu/home-refresh
 **
 ** Table of Contents:
 ** - ITD Code (credit to ITD)
 ** - Navigation button and chat button triggers
 ** - Home Dropdowns
 ** - Scrolling navigation 
 **
 */

'use strict';

$(document).ready(function () {

  /*
   ** ITD Code. 
   */

  const feed = "https://www.getrave.com/rss/mtsu/channel1";
  $.ajax(feed, {
    accepts: {
      xml: "application/rss+xml"
    },
    dataType: "xml",
    success: function (data) {
      let xmlCount = 0;
      $(data).find('item').each(function () {
        if (!xmlCount) {
          xmlCount++;
          const alertText = $(this).find('description').text();
          if (alertText.indexOf('MTSU ALERT') > -1) {
            $('.Alert').append(alertText);
          }
        }
      });
    }
  });

  // ITD Header.
  let searchvisible = 0;
  $("#search-menu").click(function (e) {
    //This stops the page scrolling to the top on a # link.
    e.preventDefault();
    if (searchvisible === 0) {
      //Search is currently hidden. Slide down and show it.
      $("#search-form").slideDown(200);
      $("#s").focus(); //Set focus on the search input field.
      searchvisible = 1; //Set search visible flag to visible.
    } else {
      //Search is currently showing. Slide it back up and hide it.
      $("#search-form").slideUp(200);
      searchvisible = 0;
    }
  });

  /*
   ** End ITD Code.
   */

  // Navigation button animation trigger.
  $('.navbar-toggle.collapsed').click(function () {
    $(this).toggleClass('offnav onnav');
  });


  // Chat button trigger to slide out. 
  $('.chat').click(function () {
    $(this).toggleClass('open');
  });

  /*
   ** Home Dropdowns
   */

  // Selecting the dropdowns.
  const hours = document.getElementById('hours');
  const coursereserves = document.getElementById('coursereserves');
  const howdoi = document.getElementById('howdoi');
  const reserverooms = document.getElementById('reserverooms');

  // Array of the dropdowns to make it easy to iterate through.
  const dropdownArr = [hours, coursereserves, howdoi, reserverooms];

  // When the button is clicked...
  $('.iconhvr').click(function (e) {
    e.preventDefault();

    // The href attribute tells us what dropdown to show.
    const dropdownToShow = $(this).attr('href');

    // Helper booleans.
    let delayNeeded = false;
    let dropdownNotShown = true;

    // If a dropdown was showing before, make sure it dissapears. 
    dropdownArr.forEach(function (dropdown) {
      if (dropdown.style.display == 'block') {
        // If the dropdown is already showing, we just want it to hide.
        if ('#' + dropdown.id == dropdownToShow) {
          delayNeeded = !delayNeeded;
          // This changes to false, so the dropdown won't hide and then show again on click.
          dropdownNotShown = !dropdownNotShown;
        } else {
          delayNeeded = !delayNeeded;
        }
        $(dropdown).slideUp('fast');
      }
    });

    if (dropdownNotShown) {
      if (delayNeeded) {
        setTimeout(() => {
          $(dropdownToShow).slideDown('fast');
        }, 300);
      } else {
        $(dropdownToShow).slideDown('fast');
      }
    }

  });

  /*
   ** End Home Dropdowns 
   */

  /*
   ** Scrolling navigation
   */

  let scrolled = false;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 32 && !scrolled) {
      $('#logo-and-nav').toggleClass('fixed-menu');
      scrolled = !scrolled;
    } else if (window.scrollY <= 32 && scrolled) {
      $('#logo-and-nav').toggleClass('fixed-menu');
      scrolled = !scrolled;
    }
  });

  /*
   ** End Scrolling navigation
   */

  // End document.ready
});