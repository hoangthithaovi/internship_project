$(document).ready(function(){
    $(document).on('click', '.comment', function () {
        var event_id = $(this).val();
        var content  = $('#content').val();
        alert(content);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $.ajax({
                type: "POST",
                url:  "{{URL::to('comment_event')}}",
                dataType: "json",
                data: {event_id: event_id, content:content},
                success: function (data) { // What to do if we succeed
                    console.log(data);
                   var comment = '<div class="well">'
                    + '<div class="media">'
                    + '<div class="row">'
                    + '<div class="col-md-2">'
                    + $('#username').attr("value") + '<br>'
                    + '</div>' + '<div class="col-md-7">'+ data.content + '<br>' + '</div>' + '<div class="col-md-3">' + '<p>' + '<span class="glyphicon glyphicon-time">' + '</span>' + 'Posted:'
                    + data.created_at + '</p>' + '</div>' + '</div>' + '<div id="show_reply_' + data.id + '" style="margin-top: 35px;"></div>' + '</div>'
                    + '<div class="button">' + '<button type="button" class="replyPro btn btn-primary" data-toggle="collapse" data-target="#replyForProduct_'
                    + data.id + '">' + '<span class="glyphicon glyphicon-collapse-down"></span>' + 'Write Reply' + '</button>' + '</div>'
                    + '<div class="well collapse" id="replyForProduct_' + data.id + '">'
                    + '<form id="replyComment_' + data.id + '" name="comment" method="POST" enctype="multipart/form-data">'
                    + '<input type="hidden" id="token_reply" name="_token" value="' + $('input[name="_token"]').val() + '"/>'
                    + '<input type="hidden" id="pro_id_' + data.id + '" name="event_id" value="' + data.event_id + '">'
                    + '<input type="hidden" id="parent_id_' + data.id + '" name="parent_id" value="' + data.id + '">'
                    + '<input type="hidden" id="user_id" value="' + data.user_id + '"/>'

                    + '<div class="form-group">'
                    + '<label for="content">Content:</label>'

                    + '<textarea id="reply_content_' + data.id + '" name="content" class="form-control" rows="5" placeholder="Enter Content" required></textarea>'
                    + '<span class="text-danger"></span>'
                    + '</div>'

                    + '<div class="form-group">'
                    + '<button class="btn btn-primary reply" data-id="' + data.id + '" value="Reply">Reply</button>'
                    + '</div>'
                    + '</form>'
                    + '</div>'

                    + '</div>';
                    $('#show_comment').append(comment);
                    $('#content').val('');
                },
                error: function (data) {
                console.log('Error:', data);
            }
            })
    });
});