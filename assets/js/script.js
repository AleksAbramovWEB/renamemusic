
const JSON_URL = 'data.json?nocache=' + (new Date()).getTime();


function my_ajax(){
    $.ajax({
        url: document.location.href,
        type: 'POST',
        data: ({go_rename: true}),
        beforeSend: function() {
            $('.music_ready').empty();
            let timer0 = setTimeout(function tick1() {
                $.getJSON(JSON_URL,  function(data) {
                    if (data.percent !== 100){
                        let timerId = setTimeout(function tick() {
                            $('.music_ready').empty();
                            $.getJSON(JSON_URL,  function(data) {
                                $('.progress-bar-striped').css('width', data.percent+'%');
                                var html = '';
                                for (var key in data.files_ready){
                                    html = '<p class="m-0" id="music_ready_'+key+'">'+data.files_ready[key]+'</p>'+html;
                                }
                                $('.music_ready').html(html);
                                if (data.percent === 100){
                                    $('.spinner-border').addClass('d-none');
                                    $('.btn-outline-dark').removeClass('d-none');
                                    return true;
                                }
                                timerId = setTimeout(tick, 500);
                            });
                        }, 500);
                        return true;
                    }
                    timer0 = setTimeout(tick1, 500);
                });
            }, 500);
        },
    });

}





$('.btn-outline-dark').on('click', function (){
    $.getJSON(JSON_URL,  function(data) {
        if (data.percent === 100){
            $('.btn-outline-dark').addClass('d-none');
            $('.spinner-border').removeClass('d-none');
            my_ajax();
        }
    });
})
