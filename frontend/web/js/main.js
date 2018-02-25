/**
 * Created by Davron on 22.02.2018.
 */

/**
 * Created by Davron on 22.02.2018.
 */

$(document).ready(function () {

    var param = $('meta[name=csrf-param]').attr("content");
    var token = $('meta[name=csrf-token]').attr("content");


    $(document).on('click', 'li', function(e){
        $(this).toggleClass('selected');
        if ($('li.selected').length == 0)
            $('.select').removeClass('selected');
        else
            $('.select').addClass('selected');
        counter();
    });

    // all item selection
        $(document).on('click', '.select', function(e){
        if ($('li.selected').length == 0) {
            $('li').addClass('selected');
            $('.select').addClass('selected');
        }
        else {
            $('li').removeClass('selected');
            $('.select').removeClass('selected');
        }
        counter();
    });

    // number of selected items
    function counter() {
        if ($('li.selected').length > 0)
            $('.send').addClass('selected');
        else
            $('.send').removeClass('selected');
        $('.send').attr('data-counter',$('li.selected').length);
    }

    //# sourceURL=pen.js


    $(document).on('click', 'li', function(e){
        $(this).toggleClass("check");
        var form = document.querySelectorAll('li.selected'); //html elementlarning ichidan zarurini ajratamiz
        var id = {};//bosh massiv yaratamiz

        for (var i = 0; i < form.length; i++) {
            id[i] = form[i].id; //elementlaning id nomerlarini massivga joylaymiz
        }
        if(form.length === 0){
            $('#food-image').html('<img src="images/serebro.jpg" width="250" />');
            $('#search-result').html('<strong class="text-warning">Biror masalliqni tanlang</strong>');
            return 222;
        }
        $.ajax({
            url: "/site/search",
            type: 'post',
            dataType: "json",
            data: {"selected": id, "param": token},
            success: function(data, response, textStatus, jqXHR) {
                if (data.status === 1) {
                    var result = data['result'];
                    var img = data['img'];
                    $('#search-result').html(result);
                    if (img){
                        $('#food-image').html('<img src="images/'+img+'" width="250" />');
                    }else{
                        $('#food-image').html('<img src="images/loader-food.gif" width="250" />');
                    }

                } else {
                    $('#food-image').html('<img src="images/serebro.jpg" width="250" />');
                    $('#search-result').html('<strong class="text-danger">Xatolik yuz berdi</strong>');
                }
            }
        });
        return false;
    });


    //owl poxoj
    $("#ingridents-owl").owlCarousel({
        autoPlay: true,
        slideSpeed:1500,
        pagination:false,
        navigation:true,
        items : 7,
        /* transitionStyle : "fade", */    /* [This code for animation ] */
        navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        itemsDesktop : [1199,5],
        itemsDesktopSmall : [980,4],
        itemsTablet: [768,2],
        itemsMobile : [479,1],
        jsonPath : '/site/foods',
        jsonSuccess : customDataSuccess
    });


    function customDataSuccess(data){
        var content = "";

        for(var i in data["items"]){

            var img = data["items"][i].img;
            var title = data["items"][i].title;
            var id = data["items"][i].id;

            content += "<li id='"+id+"'><img src='/images/"+img+"' alt='"+title+"' /></li>"
        }
        $("#ingridents-owl").html(content);
    }
});

