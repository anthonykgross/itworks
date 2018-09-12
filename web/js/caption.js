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
        var timecode = caption.match(/(\d{2}:\d{2}:\d{2},\d{3}) --&gt; /i)[1];
        var content = caption.match(/\d{1,}\n\d{2}:\d{2}:\d{2},\d{3} --&gt; \d{2}:\d{2}:\d{2},\d{3}\n(.*\n.*\n)/i)[1];
        elm.append(create_div(id, timecode, content));
    }

    raw_elm.after(elm);
});

function create_div(id, timecode, content) {
    return $('<div/>').html(content)
        .attr('data-id', id)
        .attr('data-timecode-start', timecode)
}