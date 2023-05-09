/* global fcom, langLbl */
$(document).ready(function () {
	//getThread(sessionStorage.getItem('threadId'), 1);
	//setInterval(getMessageCount, 5000);
	   /*var git = setInterval(function () {
           fcom.updateWithAjax(fcom.makeUrl('Messages', 'getUnreadCount'), '', function (response) {
				if (response.messCount > 0) {
					let messages = (response.messCount >= 100) ? '100+' : response.messCount;
					console.log(response)
					//$('.message-badge').attr('data-count', messages);
					//console.log($('.getthread').attr('data-ThreadId'));
					//console.log($(".is-getthread").children(".getthread").attr("data-threadid"));
					getThread($(".is-getthread").children(".getthread").attr("data-threadid"),1);
					//getThread(83,1);
					
				}
				$('.message-badge').removeAttr("data-count");
			});
        }, 2000);*/
		
	//setInterval(getThread,2000,83,1);
    var frm = document.frmMessageSrch;
    threadListing(frm);
    $(".window__search-field-js").click(function () {
        $(".window__search-form-js").toggle();
    });
    if (sessionStorage.getItem('threadId') != null) {
        getThread(sessionStorage.getItem('threadId'));
		sessionStorage.removeItem('threadId');
    }
    $(".msg-list__action-js").click(function () {
		alert();
		$(".msg-list__action-js").removeClass("active-chat");
        $(this).parent().toggleClass("is-active");
        $(".message-details-js").show();
        $("html").addClass("show-message-details");
		$(this).addClass("active-chat");
        return false;
    });
    $(".msg-close-js").click(function () {
        $(".message-details-js").hide();
        $("html").removeClass("show-message-details");
        return false;
    });
    $(document).on('keyup', 'textarea[name="message_text"]', function (e) {
        if (e.keyCode == 13) {
            sendMessage(document.frmSendMessage);
        }
    })
	$(".is-read").addClass("is-active");
	$(".message-details-js").show();
	$("html").addClass("show-message-details");
});
var messageThreadPage = 1;
var messageThreadAjax = false;
var div = '#threadListing';
function threadListing(frm, id) {
    var data = fcom.frmData(frm);
    data = data + "&isactive=" + id;
    fcom.ajax(fcom.makeUrl('Messages', 'search'), data, function (res) {
        $(div).html(res);
    });
	console.log(id);
	setTimeout(function() {
		$('.msg-list-'+id).addClass('is-read is-active is-getthread');
	}, 4000);
	 //$('.msg-list-' + id).addClass('is-read is-active is-getthread');
	
   $(".window__search-form-js").hide();
}

function getMessageCount() {
    fcom.updateWithAjax(fcom.makeUrl('Messages', 'getUnreadCount'), '', function (response) {
        if (response.messCount > 0) {
            let messages = (response.messCount >= 100) ? '100+' : response.messCount;
            $('.message-badge').attr('data-count', messages);
            return true;
        }
        $('.message-badge').removeAttr("data-count");
    });
}
clearSearch = function () {
    document.frmMessageSrch.reset();
    threadListing(document.frmMessageSrch);
};
$(".select-box__value-js").click(function () {
    $(".select-box__target-js").slideToggle();
});
/* FUNCTION FOR SCROLLBAR */
function closethread() {
    $("body .message-details-js").hide();
    $("html").removeClass("show-message-details");
}

function getThread(id, page) {
    page = (page) ? page : messageThreadPage;
    if (page == 1) {
        messageThreadAjax = false;
    }
    if (messageThreadAjax) {
        return false;
    }
    $('.msg-list').removeClass('is-active is-getthread');
    $('.msg-list-' + id).addClass('is-read is-active is-getthread');
    messageThreadPage += 1;
    dv = ".message-details-js";
    var data = "thread_id=" + id + "&page=" + page;
	
    fcom.ajax(fcom.makeUrl('Messages', 'messageSearch'), data, function (ans) {
        var data = JSON.parse(ans);
        if (page == 1) {
            $(dv).html(data.html).show();
            $("html").addClass("show-message-details");
            $(".chat-room__body").scrollTop($(".chat-room__body")[0].scrollHeight);
        } else {
            $('.load-more-js').remove();
            $('.chat-list').prepend(data.html);
        }
    });
    $('html').addClass('show-message-details');
    //threadListing(document.frmMessageSrch, id);
    getMessageCount();
}
//setInterval(getMessageCount, 500);
function sendMessage(frm) {
    if (document.getElementById('message_file').files.length < 1) {
        if (!$(frm).validate()) {
            return;
        }
    }
    fcom.process();
    var formData = new FormData(frm);
    fcom.ajaxMultipart(fcom.makeUrl('Messages', 'sendMessage'), formData, function (data) {
		var id=$(".is-getthread").children(".getthread").attr("data-threadid");
        messageThreadPage = 1;
        getThread(data.threadId);
        threadListing(document.frmMessageSrch,id);
		
    }, {fOutMode: 'json'});
	//var id=$(".is-getthread").children(".getthread").attr("data-threadid");
	
    return false;
}

function selectFile(obj) {
    $('#message_text').attr('data-fatreq', '{"required":false,"lengthrange":[0,1000]}');
    var html = '<div class="attachment__item">';
    html += obj.files[0].name;
    html += '<a href="javascript:void(0)" class="attachment__item_remove" onclick="removeSelectedFile()"><svg class="icon icon--close icon--small" xmlns = "http://www.w3.org/2000/svg" viewBox = "0 0 24 24" ><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"></path></svg ></a>';
    html += "</div>";
    $('#selectedFilesList').html(html);
}

function removeSelectedFile() {
    $('#message_file').val('');
    $('#selectedFilesList').html('');
}

function deleteAttachment(msgId) {
    if (!confirm(langLbl.confirmRemove)) {
        return;
    }
    formData = 'msg_id=' + msgId;
    fcom.updateWithAjax(fcom.makeUrl('Messages', 'deleteAttachment'), formData, function (data) {
        $('#msgRow' + msgId).remove();
    });
}