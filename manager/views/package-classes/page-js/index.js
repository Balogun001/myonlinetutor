/* global fcom, langLbl */
$(function () {
    var currentPage = 1;
    var dv = '#listItems';
    search = function (frm) {
        fcom.ajax(fcom.makeUrl('PackageClasses', 'search'), fcom.frmData(frm), function (t) {
            $(dv).html(t);
        });
    };
    viewLearners = function (id) {
        fcom.ajax(fcom.makeUrl('PackageClasses', 'learners', [id]), '', function (t) {
            fcom.updateFaceboxContent(t);
        });
    };

    clearSearch = function () {
        document.frmSrch.reset();
        document.frmSrch.teacher_id.value = '';
        search(document.frmSrch);
    };
    goToSearchPage = function (page) {
        var frm = document.frmSearchPaging;
        $(frm.page).val(page);
        search(frm);
    };
    $(document).on('click', function () {
        $('.autoSuggest').empty();
    });
    $('input[name=\'teacher\']').autocomplete({
        'source': function (request, response) {
            fcom.updateWithAjax(fcom.makeUrl('Users', 'AutoCompleteJson'), {
                keyword: request
            }, function (result) {
                response($.map(result.data, function (item) {
                    return {
                        label: escapeHtml(item['full_name'] + ' (' + item['user_email'] + ')'),
                        value: item['user_id'], name: item['full_name']
                    };
                }));
            });
        },
        'select': function (item) {
            $("input[name='teacher_id']").val(item.value);
            $("input[name='teacher']").val(item.name);
        }
    });
    $('input[name=\'teacher\']').keyup(function () {
        $('input[name=\'teacher_id\']').val('');
    });
    search(document.frmSrch);
});