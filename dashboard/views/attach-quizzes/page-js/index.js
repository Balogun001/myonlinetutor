$(function () {
    searchQuizzes = function (frm, page = 1) {
        document.frmSearch.pageno.value = page;
        fcom.updateWithAjax(fcom.makeUrl('AttachQuizzes', 'search'), fcom.frmData(frm), function (res) {
            if (page > 1) {
                $('#quiz-listing tbody').append(res.html);
            } else {
                $('#quiz-listing tbody').html(res.html);
            }
            if (res.loadMore == 1) {
                $('.loadMoreJs a').data('page', res.nextPage);
                $('.loadMoreJs').show();
            } else {
                $('.loadMoreJs').hide();
            }
        });
    };
    clearQuizSearch = function () {
        document.frmSearch.reset();
        searchQuizzes(document.frmSearch);
    };
    attachQuizzes = function () {
        var frm = document.frmQuizLink;
        if (!$(frm).validate()) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('AttachQuizzes', 'setup'), fcom.frmData(frm), function (res) {
            $.facebox.close();
            if (document.frmSearchPaging) {
                search(document.frmSearchPaging);
                return;
            }
            var html = '';
            // window.location.reload();

        });
    };
    goToQuizPage = function (_obj) {
        searchQuizzes(document.frmSearch, $(_obj).data('page'));
    }
    quizListing = function (recordId, recordType) {
        fcom.ajax(fcom.makeUrl('AttachQuizzes', 'index'), { recordId, recordType }, function (response) {
            $.facebox(response, 'facebox-large');
            searchQuizzes(document.frmSearch);
        });
    };
    viewQuizzes = function (recordId, recordType) {
        $.facebox.close();
        fcom.ajax(fcom.makeUrl('AttachQuizzes', 'view'), { recordId, recordType }, function (response) {
            $.facebox(response, 'facebox-large');
        });
    };
    // viewQuizzes_count = function (recordId, recordType) {
    //     // $.facebox.close();
    //     // $('#app-alert').hide();
    //     fcom.updateWithAjax(fcom.makeUrl('AttachQuizzes', 'view_count'), { recordId, recordType }, function (response) {
    //         // if(parseInt(response)>0){
    //             var anchot_tag = '<a href="javascript:void(0);" id="view_quiz_count" onclick="viewQuizzes('+recordId+','+recordType+')" class="attachment-file padding-2">\n\
    //             <svg class="icon icon--issue icon--attachement icon--xsmall color-black">\n\
    //                 <use xlink:href="/dashboard/images/sprite.svg#attach"></use>\n\
    //             </svg>\n\
    //             '+response+' Quizzes Attached</a>';
    //             if($.trim($('#atteach_div').html()) == ''){
    //                 $('#atteach_div').html(anchot_tag)
    //             }else{
    //                 $('#view_quiz_count').replaceWith(anchot_tag)
    //             }
    //         // }
    //     }, {failed: true});
    // };
    removeQuiz = function (id) {
        if (!confirm(langLbl.confirmRemove)) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('AttachQuizzes', 'delete'), { id }, function (response) {
            $('.quizRow' + id).remove();
            $('.noRecordJS').hide();
            if ($('.quizRowJs').length == 0) {
                $('.noRecordJS').show();
            }
            if (document.frmSearchPaging) {
                search(document.frmSearchPaging);
                return;
            }
            // window.location.reload();
        });
    };
    view = function (id) {
        if ($('.userListJs' + id).hasClass('is-active')) {
            $('.userListJs' + id).hide().removeClass('is-active').removeClass('is-expanded');
            return;
        } else {
            $('.userListJs').removeClass('is-active').removeClass('is-expanded').hide();
            $('.userListJs' + id).addClass('is-active').addClass('is-expanded').show();
        }
    };
    setQuiz = function (id, obj) {
        $('.quizTitleJs').text($(obj).data('title'));
        $('input[name="course_quilin_id"]').val(id);
        $('.attachedQuizJs').show();
        $.facebox.close();
    };
});
