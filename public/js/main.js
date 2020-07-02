var url = 'http://proyecto.com.devel';

window.addEventListener("load", function () {
    //cambiar el color  del like

    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    //like
    function like() {
        $('.btn-like').unbind('click').click(function () {
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'images/favorite-2-red.png');

            $.ajax({
                url: url + '/like/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        console.log('like correcto');
                    }else{
                        console.log('like incorrecto');
                    }
                }

            });

            dislike();
        })
    }

    like();

    //dislike
    function dislike() {
        $('.btn-dislike').unbind('click').click(function () {
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'images/favorite-2-gray.png');

            $.ajax({
                url: url + '/dislike/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        console.log('dislike correcto');
                    }else{
                        console.log('dislike incorrecto');
                    }
                }

            });

            like();
        })
    }
    dislike();
    // BUSCADOR

    // BUSCADOR
	$('#buscador').submit(function(e){
		$(this).attr('action',url+'/searched/'+$('#buscador #search').val());
	});
    

}); 


