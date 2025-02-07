var url = 'http://proyecto-laravel.com.devel';
window.addEventListener("load", function(){
    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');
    
    //Botón de like
    function like(){
        $('.btn-like').unbind('click').click(function(){
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'/img/heart-red.png');
            
            $.ajax({
                url: url+'/like/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('You liked');
                    }else{
                        console.log('Like failed');
                    }
                }
            });
            
            dislike();
        });
    }
    like();
    
    //Botón de dislike
    function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'/img/heart.png');
            
            $.ajax({
                url: url+'/dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('You disliked');
                    }else{
                        console.log('Dislike failed');
                    }
                }
            });
            
            like();
        });
    }
    dislike();
    
    // BUSCADOR
    $('#buscador').submit(function(){
        $(this).attr('action',url+'/gente/'+$('#buscador #search').val());
    });
    
    // MODAL
//    document.querySelectorAll('.dropdown-item').forEach(item => {
//        item.addEventListener('click', function (event) {
//            event.stopPropagation(); // Evita que el dropdown se cierre automáticamente
//        });
//    });
});