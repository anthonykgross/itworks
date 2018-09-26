var player;
var timer;

$(document).ready(function(){
    var raw_elm = $('#raw-captions');
    var raw_captions = raw_elm.html();
    raw_elm.css('display', 'none');

    var regexp = /\d{1,}\n\d{2}:\d{2}:\d{2},\d{3} --&gt; \d{2}:\d{2}:\d{2},\d{3}\n.*\n.*\n/gi;
    var captions = raw_captions.match(regexp);


    var elm = $('<div/>').addClass('final-captions');
    for(var i = 0; i < captions.length; i++) {
        var caption = captions[i];

        var id = caption.match(/(\d{1,})\n/i)[1];
        var timecode_start = caption.match(/(\d{2}:\d{2}:\d{2},\d{3}) --&gt; /i)[1];
        var timecode_end = caption.match(/ --&gt; (\d{2}:\d{2}:\d{2},\d{3})/i)[1];
        var content = caption.match(/\d{1,}\n\d{2}:\d{2}:\d{2},\d{3} --&gt; \d{2}:\d{2}:\d{2},\d{3}\n(.*\n.*\n)/i)[1];

        var seconds_start = convertTimecodeToSecond(timecode_start);
        var seconds_end = convertTimecodeToSecond(timecode_end);
        elm.append(create_div(id, timecode_start, timecode_end, seconds_start, seconds_end, content));
    }

    raw_elm.after(elm);
});

function onYouTubeIframeAPIReady() {
    var elm = $('#player');

    player = new YT.Player(
        elm.attr('id'), {
            height: '315',
            width: '560',
            videoId: elm.attr('data-youtube-id'),
            events: {
                'onStateChange': onPlayerStateChange
            }
        }
    );
}

function create_div(id, timecode_start, timecode_end, seconds_start, seconds_end, content) {
    var i = $('<i/>').addClass('fa fa-play');

    return $('<div/>').html(content).prepend(i)
        .attr('data-id', id)
        .attr('data-timecode-start', timecode_start)
        .attr('data-timecode-end', timecode_end)
        .attr('data-seconds-start', seconds_start)
        .attr('data-seconds-end', seconds_end)
        .on('click', function(){
            player.seekTo($(this).attr('data-seconds-start'));
            player.playVideo();
        })
        ;
}


function convertTimecodeToSecond(timecode) {
    var index_comma = timecode.indexOf(',');
    var final_timecode = timecode.substring(0, index_comma);
    var times = final_timecode.split(':');

    var hours = times[0];
    var minutes = times[1];
    var seconds = times[2];

    return parseInt(hours)*60*60+parseInt(minutes)*60+parseInt(seconds);
}

function onPlayerStateChange(event) {
    if(event.data === 1) {
        playCaptions();
    } else {
        stopCaptions();
    }

}

function playCaptions() {

    var elm = $('.final-captions div');

    timer = setInterval(function(){
        var current_time = player.getCurrentTime();
        elm.removeClass('active');

        for(var i = 0; i < elm.length; i++) {
            var e = $(elm[i]);
            var seconds_start = e.attr('data-seconds-start');
            var seconds_end = e.attr('data-seconds-end');

            if (current_time >= seconds_start && current_time <= seconds_end){
                e.addClass('active');
            }
        }
    }, 1000);
}

function stopCaptions() {
    clearInterval(timer);
}