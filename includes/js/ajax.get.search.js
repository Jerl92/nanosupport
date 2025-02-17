 
function nanosupport_search_ajax($) {    
    jQuery( "#s" ).on( "keyup", function(event) {
        var inputVal = document.getElementById("s").value;
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        if(inputVal.length > 3){

        $.ajax({
            type: 'post',
            url: ajax_ns_get_search_url,
            data: {
                'inputVal': inputVal,
                'action': 'ns_get_search'
            },
            dataType: 'JSON',
            success: function(data) {
                    console.log(data);
                        $('#searchform').append('<div id="widget-mcplayer-search-result"></div>');
                        jQuery("#widget-mcplayer-search-result").css("display","block");
                        jQuery("#widget-mcplayer-search-result").css("position","absolute");
                        jQuery("#widget-mcplayer-search-result").css("z-index","99");
                        jQuery("#widget-mcplayer-search-result").css("margin-top","15px");
                        jQuery("#widget-mcplayer-search-result").css("border","0.05px solid #000");
                        jQuery("#widget-mcplayer-search-result").css("background","#fff");
                        jQuery("#widget-mcplayer-search-result").css("width","98%");
                        jQuery("#widget-mcplayer-search-result").css("overflow-y","scroll");
                        jQuery("#widget-mcplayer-search-result").css("overflow-x","none");
                        jQuery("#widget-mcplayer-search-result").html(data);
                        var windowheight = jQuery(window).height();
                        var wrapplayer = jQuery('#wrap-player').height();
                        var searchwrapper = jQuery('#widget-mcplayer-search-wrapper').height();
                        if(windowheight >= searchwrapper){
                            jQuery("#widget-mcplayer-search-result").css("height", searchwrapper+35);
                        } else {
                            jQuery("#widget-mcplayer-search-result").css("height", windowheight-wrapplayer-250);
                        }
                },
                error: function(error) {
                    console.log(error);
                }
            })
        } else {
            jQuery("#widget-mcplayer-search-result").css("display","none");
        }
        });
        jQuery('#s').mouseup(function(event) {
            var inputVal = document.getElementById("s").value;
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

            if(inputVal.length > 3){
        
                $.ajax({
                    type: 'post',
                    url: ajax_ns_get_search_url,
                    data: {
                        'inputVal': inputVal,
                        'action': 'ns_get_search'
                    },
                    dataType: 'JSON',
                    success: function(data) {
                            $('#searchform').append('<div id="widget-mcplayer-search-result"></div>');
                            jQuery("#widget-mcplayer-search-result").css("display","block");
                            jQuery("#widget-mcplayer-search-result").css("position","absolute");
                            jQuery("#widget-mcplayer-search-result").css("z-index","99");
                            jQuery("#widget-mcplayer-search-result").css("margin-top","15px");
                            jQuery("#widget-mcplayer-search-result").css("border","0.05px solid #000");
                            jQuery("#widget-mcplayer-search-result").css("background","#fff");
                            jQuery("#widget-mcplayer-search-result").css("width","98%");
                            jQuery("#widget-mcplayer-search-result").css("overflow-y","scroll");
                            jQuery("#widget-mcplayer-search-result").css("overflow-x","none");
                            jQuery("#widget-mcplayer-search-result").html(data);
                            var windowheight = jQuery(window).height();
                            var wrapplayer = jQuery('#wrap-player').height();
                            var searchwrapper = jQuery('#widget-mcplayer-search-wrapper').height();
                            if(windowheight >= searchwrapper){
                                jQuery("#widget-mcplayer-search-result").css("height", searchwrapper+35);
                            } else {
                                jQuery("#widget-mcplayer-search-result").css("height", windowheight-wrapplayer-250);
                            }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })
            } else {
                jQuery("#widget-mcplayer-search-result").css("display","none");
            }
            });
}

jQuery(document).on('click', function (event) {
    if (jQuery(event.target).closest("#widget-mcplayer-search-result").length === 0) {
        jQuery("#widget-mcplayer-search-result").hide();
    }
});
 
 jQuery(document).ready(function($) {
    nanosupport_search_ajax($);
});