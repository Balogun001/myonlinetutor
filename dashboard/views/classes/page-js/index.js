/* global monthNames, langLbl, fcom, VIEW_CALENDAR, VIEW_LISTING, VIEW_LISTING */
(function () {
    goToSearchPage = function (pageno) {
        var frm = document.frmSearchPaging;
        $(frm.pageno).val(pageno);
        search(frm);
    };
    searchListing = function (frm) {
        fcom.ajax(fcom.makeUrl('Classes', 'search'), fcom.frmData(frm), function (response) {
            $("#listing").html(response);
        });
    };
    search = function (form) {
        var view = (form && form.view.value) ? parseInt(form.view.value) : VIEW_LISTING;
        switch (view) {
            case VIEW_CALENDAR:
                getCalendarView();
                break;
            case VIEW_LISTING:
            default:
                searchListing(form);
                break;
        }
    };
    getCalendarView = function () {
        fcom.ajax(fcom.makeUrl('Classes', 'calendarView'), '', function (response) {
            $("#listing").html(response);
        });
    };
    clearSearch = function () {
        document.frmClassSearch.reset();
        search(document.frmClassSearch);
    };
    addForm = function (classId) {
        fcom.ajax(fcom.makeUrl('Classes', 'addForm'), {classId: classId}, function (response) {
            $.facebox(response, 'facebox-medium');
            bindDatetimePicker("#grpcls_start_datetime");
        });
    };
    setupClass = function (form, goToLangForm) {
        if (!$(form).validate()) {
            return;
        }
        var data = new FormData(form);
        fcom.ajaxMultipart(fcom.makeUrl('Classes', 'setupClass'), data, function (res) {
            search(document.frmClassSearch);
            if (goToLangForm && $('.lang-li').length > 0) {
                langId = $('.lang-li').first().attr('data-id');
                langForm(res.classId, langId);
                return;
            }
            $.facebox.close();
        }, {fOutMode: 'json'});
    };
    langForm = function (classId, langId) {
        fcom.ajax(fcom.makeUrl('Classes', 'langForm'), {classId: classId, langId: langId}, function (response) {
            $.facebox(response, 'facebox-medium');
        });
    };
    setupLangData = function (form, goToNext) {
        if (!$(form).validate()) {
            return;
        }
        fcom.updateWithAjax(fcom.makeUrl('Classes', 'setupLang'), fcom.frmData(form), function (res) {
            search(document.frmClassSearch);
            if (goToNext && $('.lang-list .is-active').next('li').length > 0) {
                $('.lang-list .is-active').next('li').find('a').trigger('click');
                return;
            }
            $.facebox.close();
        });
    };
    formatSlug = function (fld) {
        var slug = $(fld).val();
        slug = slug.trim(slug.toLowerCase());
        slug = slug.replace(/[\s,<>\/\"&#%+?$@=]/g, "-");
        slug = slug.replace(/[\s\s]+/g, '-');
        slug = slug.replace(/[\-]+/g, '-');
        $(fld).val(slug);
        if (slug != '') {
            checkUnique($(fld), 'tbl_group_classes', 'grpcls_slug', 'grpcls_id', $('#grpcls_id'), []);
        }
    };
    expandGroupClassthough = function(){
        $.facebox('<iframe width="100%" height="600px" src="https://www.youtube.com/embed/3mawz89vWt0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" class="mb-4"></iframe>', 'facebox-large');
    }
})();