window.onload = function () {
    $('.detail_msg').hide('');
    if ($(".chat_list").length > 0) {
        $(".chat_list").each(function () {
            checkToken($(this));
        });
        setTimeout(function () {
            $("#loader").fadeOut(2500);
            setTimeout(function () {
                $(".loader_css").removeClass(".loader_css");
                $(".loader-hide-this").each(function () {
                    $(this).removeClass("loader-hide-this");
                });
                $("#loader").remove();
            }, 2000);
        }, 1000);
    }
};
$(document).on("click", ".chat_list", function () {
    $(".chat_list").removeClass("active_chat");
    $(this).addClass("active_chat");
    $(".detail_msg").hide();
    $(".loader-msg").show();
    me = $(this);
    username = $(this).find(".username").html();
    $("#username-bloc").html(username);
    token = $(this).attr("data-token");

    if (token.length <= 0) {
        checkToken(me);
    }
    $(".input_msg_write").attr("data-token", token);
    setTimeout(function () {
        $(".msg_history").attr("data-token", token);
        $(".loader-msg").hide();
        $(".detail_msg").show();
    }, 2500);
});

$(document).on("click", ".msg_send_btn", function () {
    token = $(this).parent().attr("data-token");
    sendMessages(token, $(".write_msg").val());
    $(".write_msg").val("");
});

function checkToken(me) {
    id_user_tchat = $(me).data("id-user");
    values = {id_user_tchat: id_user_tchat};
    $.ajax({
        method: "POST",
        url: "/ajax",
        data: {action: "checkToken", values: values},
        success: function (data) {
            data = data.replace(/\s+/g, '');
            $(me).attr("data-token", data);
            //  $(".input_msg_write").attr("data-token", data);
        },
    });
}

function sendMessages(token, message) {
    values = {token: token, message: message};
    $.ajax({
        method: "POST",
        url: "/ajax",
        data: {action: "sendMessage", values: values},
        success: function (data) {
        },
    });
}

setInterval(function () {
    token = 'undefined';
    token = $('.input_msg_write').attr('data-token');
    if (typeof token !== "undefined") {
        refreshMessages($('.input_msg_write').attr('data-token'));
    }
    //checkNotification();
}, 2500);

function refreshMessages(token) {
    values = {token: token};
    $.ajax({
        method: "POST",
        url: "/ajax",
        data: {action: "refreshMessages", values: values},
        success: function (data) {
            $(".msg_history").html(data);
            $(".msg_history")
                .stop()
                .animate(
                    {
                        scrollTop: $(".msg_history")[0].scrollHeight,
                    },
                    800
                );
        },
    });
}

$(document).on('click', '.mesgs', function () {
    token = $(this).find('.input_msg_write').attr('data-token');
    //seeMessage(token);
})

function getMessages(token) {
    values = {token: token};
    $.ajax({
        method: "POST",
        url: "/ajax",
        data: {action: "getMessages", values: values},
        success: function (data) {
            $(me).attr("data-token", data);
        },
    });
}


$(document).on("keyup", function (event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        $(".msg_send_btn").trigger("click");
    }
});
