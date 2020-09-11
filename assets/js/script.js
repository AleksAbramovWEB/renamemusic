
const JSON_URL = 'data.json?nocache=' + (new Date()).getTime()


async function my_ajax(){
    $('.music_ready').empty()

    const goRenameAjax = () =>
        $.ajax({
            url: document.location.href,
            type: 'POST',
            data: ({go_rename: true}),
            beforeSend(){
                let interval = setInterval(() => {
                    $.getJSON(JSON_URL, (data) => {
                        if (data.percent !== 100) clearInterval(interval)
                        console.log(data.percent)
                    })
                }, 100)
            }
        })



    const getJsonData = () => {
       let interval =  setInterval(  () => {
            $('.music_ready').empty();
            $.getJSON(JSON_URL,  (data) => {
                    $('.progress-bar-striped').css('width', data.percent+'%');
                    let html = '';
                    for (let key in data.files_ready){
                        html = '<p class="m-0" id="music_ready_'+key+'">'+data.files_ready[key]+'</p>'+html;
                    }
                    $('.music_ready').html(html);
                    if (data.percent === 100){
                        console.log(data.percent)
                        clearInterval(interval);
                        $('.spinner-border').addClass('d-none');
                        $('.btn-outline-dark').removeClass('d-none');
                    }
                })
        }, 500)
    }

    await goRenameAjax()
    await getJsonData()

}





$('.btn-outline-dark').on('click', function (){
    $.getJSON(JSON_URL,  function(data) {
        if (data.percent !== 100) return
        $('.btn-outline-dark').addClass('d-none')
        $('.spinner-border').removeClass('d-none')
        my_ajax()
    });
})
