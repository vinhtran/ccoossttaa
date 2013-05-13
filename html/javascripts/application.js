jQuery(function() {

  /**
  * Modals
  **/
  jQuery('.close-modal').on('click', function(e)
  {
    var hideModal = jQuery(this).data('modal');
    jQuery(hideModal).removeClass('modal_active').addClass('modal');
  });


  jQuery('#show_modal_prizes').on('click', function(e)
  {
      e.preventDefault();
      jQuery('#list_prizes').removeClass('modal').addClass('modal_active');
  });

  jQuery('.gallery_fan_upload button').on('click', function(e)
  {
      e.preventDefault();
      jQuery('#upload_photos').removeClass('modal').addClass('modal_active');
  });

  jQuery('.participate_via_upload, .participate_via_vote').on('click', function(e)
  {
      e.preventDefault();
      jQuery('#register_fan').removeClass('modal').addClass('modal_active');
  });

  jQuery(document).keyup(function(e)
  {

    if(e.keyCode == 27)
    {

      jQuery('#inner_wrapper').find('.modal_active').each(function(index)
      {
        jQuery(this).removeClass('modal_active').addClass('modal');
      });

    }

  });


  /**
  * Gallery Navigation
  **/
  var activeLocation = jQuery('.destination_title').data('active-location');
  if(activeLocation !== null)
  {

    jQuery('#destination_locations').find('a').each(function(index)
    {

      if(jQuery(this).data('location-id') == activeLocation)
      {
        jQuery(this).addClass('active_location');
      }

    });

  }

});