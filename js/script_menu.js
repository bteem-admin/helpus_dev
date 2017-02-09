jQuery(function($) {
    $('#general_settings').click(function () {
        $("#general__mlinks").toggle("slow", function () {
            $('#general__mlinks').css({
                'background-color': '#DB7676'
            });
        });
    });

    
    $('#user_management').click(function () {
        $("#internal_user_mlinks").toggle("slow", function () {
            $('#internal_user_mlinks').css({
                'background-color': '#DB7676'
            });
        });
    });

    /*----------------------------------*/

    //For Toggle + and - in menu
    $('.dblink__wrp').click(function () {

        if ($(this).find('em').hasClass('minus'))
        {
            $(this).find('em').removeClass('minus');
        }
        else
        {
            $(this).find('em').addClass('minus');
        }
    });
//For Toggle + and - in menu end

    ////Menu End///
});
