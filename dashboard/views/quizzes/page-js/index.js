/* global weekDayNames, monthNames, langLbl, layoutDirection, fcom */
$(function () {
    goToSearchPage = function (pageno) {
        var frm = document.frmPaging;
        $(frm.pageno).val(pageno);
        search(frm);
    };
    search = function (frm) {
        fcom.ajax(fcom.makeUrl('Quizzes', 'search'), fcom.frmData(frm), function (res) {
            $("#quiz-listing").html(res);
        });
    };
    updateStatus = function (id, obj) {
        var status = $(obj).val();
        var checked = $(obj).is(':checked');
        fcom.updateWithAjax(fcom.makeUrl('Quizzes', 'updateStatus'), { id, status }, function (res) {
            search(document.frmSearch);
            return;
        });
        $(obj).prop('checked', (checked == false) ? true : false);
    }
    remove = function (id) {
        if (!confirm(langLbl.confirmRemove)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Quizzes', 'delete'), { id }, function (res) {
            search(document.frmSearch);
        });
    };
    attachQuizzes = function () {
        var frm = document.frmQuizLink;
        // if (!$(frm).validate()) {
        //     return;
        // }
        $.ajax({
            url:fcom.makeUrl('AttachQuizzes', 'setup'),
            method:"post",
            data:fcom.frmData(frm),
            success:function(res){
                console.log(frm)
                searchattempedquiz(frm)
            }
        })
    };
    searchattempedquiz = function(frm){
        $.ajax({
            url:fcom.makeUrl('AttachQuizzes', 'searchattempedquiz'),
            method:"post",
            data:fcom.frmData(frm),
            success:function(res){
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val('https://myonlinetutor.co/dashboard/user-quiz/index/'+res).select();
                document.execCommand("copy");
                $temp.remove();
                alert("Copied the text: " + $temp.val());
            }
        })
    }
    copyUrl = function(quiz_id){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val('https://myonlinetutor.co/dashboard/public-quiz/index/'+quiz_id).select();
        document.execCommand("copy");
        $temp.remove();
        alert("Copied the text: " + $temp.val());
    }
    appendquizid = function(id){
        $('#quiz_input_id').val(id)
        attachQuizzes();
    }
    clearSearch = function () {
        document.frmSearch.reset();
        search(document.frmSearch);
    };
    search(document.frmSearch);
    expandQuizwalkthough = function(){
        $.facebox('<iframe width="100%" height="600px" src="https://www.youtube.com/embed/7P_03UQV8VQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" class="mb-4"></iframe>', 'facebox-large');
    }
});
