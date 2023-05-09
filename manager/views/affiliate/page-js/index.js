/* global fcom, SITE_ROOT_FRONT_URL */
$(document).ready(function () {
    searchUsers(document.frmUserSearch);
    $("input[name='keyword']").autocomplete({
        'source': function (request, response) {
            fcom.updateWithAjax(fcom.makeUrl('Affiliates', 'AutoCompleteJson'), {
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
            $("input[name='user_id']").val(item.value);
            $("input[name='keyword']").val(item.name);
        }
    });
    $("input[name='keyword']").keyup(function () {
        $("input[name='user_id']").val('');
    });
    $(document).on('click', 'ul.linksvertical li a.redirect--js', function (event) {
        event.stopPropagation();
    });
});
(function () {
    searchUsers = function (form) {
        if (!form) {
            return;
        }
        fcom.ajax(fcom.makeUrl('Affiliate', 'search'), fcom.frmData(form), function (res) {
            $("#userListing").html(res);
        });
    };
    goToSearchPage = function (page) {
        var frm = document.frmUserSearchPaging;
        $(frm.page).val(page);
        searchUsers(frm);
    };
    userLogin = function (userId) {
        fcom.updateWithAjax(fcom.makeUrl('Affiliate', 'login', [userId]), '', function (res) {
            if (res.redirectUrl) {
                window.open(res.redirectUrl, "_blank");
            }
        });
    };
    view = function (userId) {
        fcom.ajax(fcom.makeUrl('Affiliate', 'view', [userId]), '', function (response) {
            $.facebox(response);
        });
    };
    userForm = function (id) {
        fcom.ajax(fcom.makeUrl('Affiliate', 'form', [id]), '', function (response) {
            $.facebox(response);
        });
    };
    setupUser = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Affiliates', 'setup'), fcom.frmData(frm), function (t) {
            searchUsers(document.frmUserSearchPaging);
            $(document).trigger('close.facebox');
        });
    };
    changePassword = function (userId) {
        fcom.ajax(fcom.makeUrl('Affiliate', 'changePasswordForm'), {userId: userId}, function (response) {
            $.facebox(response);
        });
    };
    updatePassword = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Affiliate', 'updatePassword'), fcom.frmData(frm), function (response) {
            $.facebox.close()
        });
    };
    goToTransactionPage = function (page) {
        var frm = document.transactionPaging;
        $(frm.page).val(page);
        transactions(frm.userId.value)
    };
    refferals = function (userId) {
        var frm = document.transactionPaging;
        fcom.ajax(fcom.makeUrl('Affiliate', 'refferals', [userId]), fcom.frmData(frm), function (response) {
            $.facebox(response);
        });
    };
    payouts = function (userId) {
        var frm = document.transactionPaging;
        fcom.ajax(fcom.makeUrl('Affiliate', 'payouts', [userId]), fcom.frmData(frm), function (response) {
            $.facebox(response);
        });
    };
    accountDetails = function (userId) {
        var frm = document.transactionPaging;
        fcom.ajax(fcom.makeUrl('Affiliate', 'accountDetails', [userId]), fcom.frmData(frm), function (response) {
            $.facebox(response);
        });
    };
    transactionForm = function (userId) {
        fcom.ajax(fcom.makeUrl('Affiliate', 'transactionForm', [userId]), '', function (response) {
            $.facebox(response);
        });
    };
    setupTransaction = function (frm) {
        if (!$(frm).validate()) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Affiliate', 'setupTransaction'), fcom.frmData(frm), function (t) {
            if (t.userId > 0) {
                transactions(t.userId);
            }
        });
    };
    changeStatus = function (obj, status) {
        var status = parseInt(status);
        var userId = parseInt(obj.id);
        var data = 'userId=' + userId + '&status=' + status;
        fcom.ajax(fcom.makeUrl('Affiliate', 'changeStatus'), data, function (response) {
            let removeClass = 'active';
            let addClass = 'inactive';
            let onclick = 'changeStatus(this,1)';
            if (status == 1) {
                removeClass = 'inactive';
                addClass = 'active';
                onclick = 'changeStatus(this,0)';
            }
            $(obj).removeClass(removeClass).addClass(addClass);
            $(".status_" + userId).attr('onclick', onclick);
        });
    };
    payoutUpdate = function (obj, status) {
        var status = parseInt(status);
        var id = parseInt(obj.id);
        var data = 'id=' + id + '&status=' + status;
        fcom.ajax(fcom.makeUrl('Affiliate', 'payoutUpdate'), data, function (response) {
            let removeClass = 'active';
            let addClass = 'inactive';
            let onclick = 'payoutUpdate(this,1)';
            if (status == 1) {
                removeClass = 'inactive';
                addClass = 'active';
                onclick = 'payoutUpdate(this,0)';
            }
            $(obj).removeClass(removeClass).addClass(addClass);
            $(".status_" + id).attr('onclick', onclick);
        });
    };
    clearUserSearch = function () {
        document.frmUserSearch.reset();
        document.frmUserSearch.user_id.value = '';
        searchUsers(document.frmUserSearch);
    };
    resendVerificationLink = function (username) {
        if (username == "undefined" || typeof username === "undefined") {
            username = '';
        }
        fcom.updateWithAjax(fcom.makeUrl('GuestUser', 'resendVerificationLink', [username], SITE_ROOT_FRONT_URL), '', function (ans) { });
    };
})();
