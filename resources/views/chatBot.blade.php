@extends('layouts.layout')

@section('title', 'chatBot')

@section('content')
<style>
    .chatBox {
        border: 1px solid #858585;
        background: #3b3b3b;
        padding: 2px;
        color: white;
    }

    #chatContentArea {
        overflow: auto;
        min-height: 20vh;
        max-height: 50vh;
    }

    .chatContent {
        height: min-content;
        width: min-content;
        background: #adb5bd;
        color: black;
        padding: 3px;
        border-radius: 5px;
        margin: 3px;
    }
</style>

<div class="container  mt-4 mb-5 fs-5">
    <table class="table">
        <tr>
            <th class="col-1">Chat</th>
            <td>
                <div id="chatContentArea" class="chatBox bg-black">
                </div>
            </td>
        </tr>
        <tr>
            <th class="col-1">Message</th>
            <td>
                <div id="chatInput" class="chatBox" contenteditable="true"></div>
            </td>
        </tr>
    </table>
</div>

<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script>
    $(function() {
        let chatServer_ip = "127.0.0.1";
        let chatServer_port = "3000";
        let socket = io(chatServer_ip + ":" + chatServer_port);

        socket.on("connection");

        let chatInput = $("#chatInput");

        chatInput.keypress(function(e) {
            if (e.which === 13 && !e.shiftKey) {
                socket.emit("sendChatToServer", $(this).html());
                $("#chatContentArea").append(`<div class="chatContent ms-auto">${$(this).html()}</div>`);
                $(this).html('');
                return false;
            }
        });

        socket.on("sendChatToClient", (message) => {
            $("#chatContentArea").append(`<div class="chatContent">${message}</div>`);

        })

    })
</script>
@endsection