$(function() {
    let chatCard = $('.chat-card');
    let hubUrl = chatCard.data('hubUrl');
    const url = new URL(hubUrl);
    url.searchParams.append('topic', 'https://example.com/chat/test');

    const eventSource = new EventSource(url);
    eventSource.onmessage = e => {
        let chatDiv = $('.chat-messages');
        let chatBackground = (chatDiv.data('chatBackground') + 1) % 2;
        chatDiv.data('chatBackground', chatBackground);
        chatDiv.append(`<div class="card rounded"><div class="card-body rounded bg-${chatBackground ? 'primary' : 'secondary'}">${e.data}</div></div>`)
    }

    $('#send-message-button').parents('form').on('submit', function(e) {
        e.preventDefault();
        let chatCard = $('.chat-card');
        let input = $('#send-message-button');
        let message = input.val();
        let data = { topic: "https://example.com/chat/test", data: message}
        let url = chatCard.data('hubUrl');
        let token = chatCard.data('jwt');
        input.val('');
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            headers: {
                Authorization: 'Bearer ' + token
            }
        }, function(html) {
            console.log(html);
        })
    })
})