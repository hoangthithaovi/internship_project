$(".reply").click(function (e) {
    var comment_id = $(this).data('id');
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('#token_reply').val()
        }
    });

    var dataReply = {
        title: 's',
        content: $('#reply_content_' + comment_id).val(),
        product_id: $('#pro_id_' + comment_id).val(),
        parent_id: $('#parent_id_' + comment_id).val()
    }

    console.log(dataReply);
    $.ajax({
        type: "POST",
        url: 'reply_product',
        data: dataReply,
        dataType: 'json',
        success: function (data) {
            alert('Thank for reply!!');
            console.log(data);

            var reply = '<div class="media" style="border: 1px solid #e3e3e3; margin-top: 10px; margin-left: 150px; margin-right: 150px;">'
                    + '<div class="col-md-3">' + '<img src="http://foodstore/' + $('#avata_image1').attr("value")
                    + '" width="50px" height="50px" style="border-radius:50%;-moz-border-radius:50%;border-radius:50%; margin: 5px;">'
                    + $('#username1').attr("value") + '<br>' + '</div>' + '<div class="col-md-6">' + data.content + '</div>' + '<div class="col-md-3">' + '<p>'
                    + '<span class="glyphicon glyphicon-time">' + '</span>' + 'Posted:' + diffForHumans(data.created_at) + '</p>' + '</div>' + '</div>';
            $('#show_reply_' + comment_id).append(reply);
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});
'<div class="well" >'
                                + '<div class="media" style="border: 1px solid #e3e3e3; margin-top: 10px; margin-left: 150px; margin-right: 150px;">'
                                    + '<div class="row">'
                                        + '<div class="col-md-3">'
                                            + $('#username').attr("value") + '<br>'
                                        + '</div>' 
                                        + '<div class="col-md-6">'+ data.content + '<br>' + '</div>' 
                                        + '<div class="col-md-3">' + '<p>' + '<span class="glyphicon glyphicon-time">' + '</span>' + 'Posted:'
                                        + data.created_at + '</p>' 
                                        + '</div>' 
                                    + '</div>' 
                                    + '<div id="show_reply_' + data.id + '" style="margin-top: 35px;"></div>' 
                                + '</div>'
                            + '</div>';





<script>
var comment_id = document.getElementById("parent_id_{{$comment['id']}}");
$('#replyForProduct' + comment_id).on("hide.bs.collapse", function(){
$(".replyPro").html('<span class="glyphicon glyphicon-collapse-down"></span> Write Reply');
});
$('#replyForProduct' + comment_id).on("show.bs.collapse", function(){
$(".replyPro").html('<span class="glyphicon glyphicon-collapse-up"></span> Close Reply');
});
</script>

<script>
var comment_id = document.getElementById("parent_id_{{$comment['id']}}");
$('#showMoreReply_' + comment_id).on("hide.bs.collapse", function(){
$(".showMorePro").html('<span class="glyphicon glyphicon-collapse-down"></span>View More Reply');
});
$('#showMoreReply_' + comment_id).on("show.bs.collapse", function(){
$(".showMorePro").html('<span class="glyphicon glyphicon-collapse-up"></span>Hide Reply');
});
</script>