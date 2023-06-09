/* global moment, confFrontEndUrl, FullCalendar, cart, langLbl, i, fcom, layoutDirection, calendar, id, id, TYPE_SUBCRIP */
var timeInterval;
var FatEventCalendar = function (teacherId, offset) {
    this.teacherId = teacherId;
    this.offset = offset;
    var seconds = 2;
    this.calDefaultConf = {
        initialView: "timeGridWeek",
        headerToolbar: {
            left: "time",
            center: "title",
            right: "prev,next today",
        },
        slotDuration: "00:15",
        buttonText: {
            today: langLbl.today,
        },
        direction: layoutDirection,
        dayHeaderFormat: "{EEE/{d}}",
        views: {
            timeGridWeek: {
                titleFormat: "{LLL {d}}, yyyy",
            },
        },
        slotLabelFormat: "{hh:mm {a}}",
        nowIndicator: true,
        navLinks: false,
        eventOverlap: false,
        slotEventOverlap: false,
        selectable: false,
        editable: false,
        selectLongPressDelay: 50,
        eventLongPressDelay: 50,
        longPressDelay: 50,
        allDaySlot: false,
        eventTimeFormat: "{hh:mm {a}}",
        loading: function (isLoading) {
            if (isLoading == true) {
                jQuery("#loaderCalendar").show();
            } else {
                jQuery("#loaderCalendar").hide();
            }
        },
    };
    updateTime = function (time, calendarObj) {
        currentTimeStr = moment(time).add(seconds, "seconds").format("YYYY-MM-DD HH:mm:ss");
        currentTimeStr = calendarObj.formatDate(currentTimeStr, "hh:mm:ss a");
        jQuery("body").find(".fc-toolbar-ltr h6 span.timer").html(currentTimeStr);
    };
    this.direction = function (direction) {
        this.calDefaultConf.direction = direction;
    };
    this.startTimer = function (currentTime, calendarObj) {
        clearInterval(timeInterval);
        timeInterval = setInterval(function () {
            this.updateTime(currentTime, calendarObj);
            seconds++;
        }, 1000);
    };
    getSlotBookingConfirmationBox = function (calEvent, calendar, isFreetrial) {
        isFreetrial = isFreetrial ? isFreetrial : false;
        var start = calendar.formatDate(calEvent.start, "hh:mm {a}");
        var end = calendar.formatDate(calEvent.end, "hh:mm {a}");
        let tooltip = jQuery(".tooltipevent-wrapper-js");
        let tooltipevent = jQuery(".tooltipevent-wrapper-js");
        selectedStartDateTime = moment(calEvent.start).format("YYYY-MM-DD HH:mm:ss");
        selectedEndDateTime = moment(calEvent.end).format("YYYY-MM-DD HH:mm:ss");
        if (tooltip.find(".book-freetrial-js").length > 0) {
            cart.prop.ordles_starttime = selectedStartDateTime;
            cart.prop.ordles_endtime = selectedEndDateTime;
        }
        if (tooltip.find("#lesson_starttime").length > 0) {
            tooltip.find("#lesson_starttime").val(selectedStartDateTime);
        }
        if (tooltip.find("#lesson_endtime").length > 0) {
            tooltip.find("#lesson_endtime").val(selectedEndDateTime);
        }
        tooltip.find(".displayEventDate").html(calendar.formatDate(calEvent.start, "LLLL, d, yyyy"));
        tooltip.find(".displayEventTime").html(start + " - " + end);
        tooltipevent.css({position: "absolute", top: "50%", left: "50%", transform: "translate(-50%,0)"});
        tooltip.css("z-index", 10000);
        tooltip.removeClass("d-none");
    };
    getSimpleCalendarSlotBookingConfirmationBox = function (calEvent, isFreetrial) {
        isFreetrial = isFreetrial ? isFreetrial : false;
        var start = moment(calEvent.start).format("HH:mm");
        var end = moment(calEvent.end).format("HH:mm");
        let tooltip = jQuery(".tooltipevent-wrapper-js");
        let tooltipevent = jQuery(".tooltipevent-wrapper-js");
        selectedStartDateTime = moment(calEvent.start).format("YYYY-MM-DD HH:mm:ss");
        selectedEndDateTime = moment(calEvent.end).format("YYYY-MM-DD HH:mm:ss");
        if (tooltip.find(".book-freetrial-js").length > 0) {
            cart.prop.ordles_starttime = selectedStartDateTime;
            cart.prop.ordles_endtime = selectedEndDateTime;
        }
        if (tooltip.find("#lesson_starttime").length > 0) {
            tooltip.find("#lesson_starttime").val(selectedStartDateTime);
        }
        if (tooltip.find("#lesson_endtime").length > 0) {
            tooltip.find("#lesson_endtime").val(selectedEndDateTime);
        }
        tooltip.find(".displayEventDate").html(moment(calEvent.start).format("MMMM, DD, YYYY"));
        tooltip.find(".displayEventTime").html(start + " - " + end);
        tooltipevent.css({position: "absolute", top: "50%", left: "50%", transform: "translate(-50%,0)"});
        tooltip.css("z-index", 10000);
        tooltip.removeClass("d-none");
    };
    updateLessonList = function (calendar) {
        let index = 0;
        for (id in cart.prop.slots) {
            let timeText = calendar.formatDate(cart.prop.slots[id].ordles_starttime, 'EEE, LLL d hh:mm a');
            timeText += " - " + calendar.formatDate(cart.prop.slots[id].ordles_endtime, 'hh:mm a');
            $('#cal-lesson-list .number-list__value').eq(index).text(timeText);
            $('#cal-lesson-list .numbers-list__item').eq(index).addClass('is-selected');
            $('#cal-lesson-list .is-delete').eq(index).removeClass('d-none').attr('data-id', id);
            index++;
        }
        for (let i = index; i < cart.prop.ordles_quantity; i++) {
            $('#cal-lesson-list .number-list__value').eq(i).text(labelToSchedule);
            $('#cal-lesson-list .numbers-list__item').eq(index).removeClass('is-selected');
            $('#cal-lesson-list .is-delete').eq(i).addClass('d-none').attr('data-id', '');
        }
        let unscheduledLessons = cart.prop.ordles_quantity - Object.keys(cart.prop.slots).length;
        if (unscheduledLessons > 0) {
            $('.unscheduled-lessson-js').text(unscheduledLessons);
            $('#lesson-drop-action .drop-action__value').text(labelToSchedule);
        } else {
            $('.unscheduled-lessson-js').text('');
            $('#lesson-drop-action .drop-action__value').text(labelAllScheduled);
        }
    }
};
FatEventCalendar.prototype.AvailaibilityCalendar = function (currentTime, duration, bookingBefore, selectable) {
    var fecal = this;
    var checkSlotAvailabiltAjaxRun = false;
    var calConf = {
        now: currentTime,
        views: {
            timeGridWeek: {
                titleFormat: "{LLL {d}}, yyyy",
                duration: {days: 7}
            },
        },
        selectable: selectable,
        eventSources: [
            {
                events: function (fetchInfo, successCallback, failureCallback) {
                    postData = "start=" + moment(fetchInfo.start).format("YYYY-MM-DD HH:mm:ss") +
                            "&end=" + moment(fetchInfo.end).format("YYYY-MM-DD HH:mm:ss") +
                            "&bookingBefore=" + bookingBefore;
                    fcom.ajax(fcom.makeUrl("Teachers", "getAvailabilityJsonData", [fecal.teacherId, ]), postData, function (res) {
                        let bookingBeforeDate = moment(currentTime).add(bookingBefore, "hours");
                        let events = [];
                        let response = res.data;
                        for (i in response) {
                            if (bookingBeforeDate >= moment(response[i].end)) {
                                continue;
                            }
                            if (moment(response[i].start) < bookingBeforeDate && moment(response[i].end) > bookingBeforeDate) {
                                response[i].start = moment(bookingBeforeDate).format("YYYY-MM-DD HH:mm:ss");
                            }
                            response[i].display = "background";
                            response[i].selectable = true;
                            response[i].editable = false;
                            events.push(response[i]);
                        }
                        successCallback(events);
                    },
                            {fOutMode: "json"}
                    );
                },
            },
            {
                events: function (fetchInfo, successCallback, failureCallback) {
                    postData = "start=" + moment(fetchInfo.start).format("YYYY-MM-DD HH:mm:ss") +
                            "&end=" + moment(fetchInfo.end).format("YYYY-MM-DD HH:mm:ss");
                    fcom.updateWithAjax(fcom.makeUrl("Teachers", "getScheduledSessions", [fecal.teacherId]), postData, function (events) {
                        successCallback(events.data);
                    });
                },
            },
        ],
        select: function (arg) {
            jQuery("body #d_calendar .closeon").click();
            jQuery("#loaderCalendar").show();
            if (checkSlotAvailabiltAjaxRun) {
                return false;
            }
            let start = moment(arg.start);
            let end = moment(arg.start).add(duration, "minutes");
            let bookingBeforeDate = moment(currentTime).add(bookingBefore, "hours");
            if (start < bookingBeforeDate) {
                jQuery("#loaderCalendar").hide();
                jQuery("body").css({cursor: "default", "pointer-events": "initial"});
                calendar.unselect();
                return false;
            }
            $.loader.show();
            checkSlotAvailabiltAjaxRun = true;
            let event = {
                start: start.format("YYYY-MM-DD HH:mm:ss"),
                end: end.format("YYYY-MM-DD HH:mm:ss"),
            };
            fcom.updateWithAjax(fcom.makeUrl("Teachers", "checkSlotAvailability", [fecal.teacherId]), event, function (res) {
                $.loader.hide();
                checkSlotAvailabiltAjaxRun = false;
                jQuery("#loaderCalendar").hide();
                jQuery("body").css({cursor: "default", "pointer-events": "initial", });
                if (res.status == 0) {
                    jQuery("body > .tooltipevent").remove();
                    calendar.unselect();
                    return;
                }
                this.getSlotBookingConfirmationBox(event, calendar, true);
            }, {failed: true});
        },
    };
    var defaultConf = this.calDefaultConf;
    var conf = {...defaultConf, ...calConf};
    var elementId = selectable ? "d_calendarfree_trial" : "d_calendar";
    var calendarEl = document.getElementById(elementId);
    var calendar = new FullCalendar.Calendar(calendarEl, conf);
    calendar.render();
    window.viewOnlyCal = calendar;
    jQuery("body").find(".fc-time-button").parent().html(
            "<h6><span>" + langLbl.myTimeZoneLabel +
            " :-</span> <span class='timer'>" + calendar.formatDate(currentTime, "hh:mm:ss {a}") +
            "</span><span class='timezoneoffset'>(" + langLbl.timezoneString + " " + this.offset + ")</span></h6>");
    seconds = 2;
    this.startTimer(currentTime, calendar);
    jQuery(".fc-today-button,button.fc-prev-button,button.fc-next-button").click(function () {
        jQuery("body > .tooltipevent").remove();
    });
    jQuery(document).bind("close.facebox", function () {
        jQuery("body > .tooltipevent").remove();
    });
};
FatEventCalendar.prototype.WeeklyBookingCalendar = function (currentTime, duration, bookingBefore, subStartDate, days) {
    var fecal = this;
    let calStartDate = moment(currentTime).format('YYYY-MM-DD');
    let calEndDate = moment(currentTime).add(days, 'days').format('YYYY-MM-DD');
    let bookingBeforeDate = moment(currentTime).add(bookingBefore, 'hours');
    if (subStartDate != '') {
        calStartDate = moment(subStartDate).format('YYYY-MM-DD');
    }
    var calConf = {
        now: currentTime,
        selectable: true,
        validRange: {
            start: calStartDate,
            end: calEndDate
        },
        views: {timeGridWeek: {titleFormat: '{LLL {d}}, yyyy', duration: {days: 7}}},
        dayHeaderFormat: '{EEE {L/d}}',
        now: currentTime,
        selectable: true,
        views: {
            timeGridWeek: {
                titleFormat: "{LLL {d}}, yyyy",
                duration: {days: 7}
            },
        },
        dayHeaderFormat: "{EEE {L/d}}",
        eventSources: [
            {
                events: function (fetchInfo, successCallback, failureCallback) {
                    postData = "start=" + moment(fetchInfo.start).format("YYYY-MM-DD HH:mm:ss") +
                            "&end=" + moment(fetchInfo.end).format("YYYY-MM-DD HH:mm:ss") + "&bookingBefore=" + bookingBefore;
                    fcom.ajax(fcom.makeUrl("Teachers", "getAvailabilityJsonData", [fecal.teacherId, ]), postData, function (res) {
                        let events = [];
                        let response = res.data;
                        for (i in response) {
                            if (bookingBeforeDate >= moment(response[i].end)) {
                                continue;
                            }
                            if (moment(response[i].start) < bookingBeforeDate && moment(response[i].end) > bookingBeforeDate) {
                                response[i].start = moment(bookingBeforeDate).format("YYYY-MM-DD HH:mm:ss");
                            }
                            response[i].display = "background";
                            response[i].selectable = true;
                            response[i].editable = false;
                            events.push(response[i]);
                        }
                        successCallback(events);
                    }, {fOutMode: "json"});
                },
            },
            {
                events: function (fetchInfo, successCallback, failureCallback) {
                    postData = "start=" + moment(fetchInfo.start).format("YYYY-MM-DD HH:mm:ss") +
                            "&end=" + moment(fetchInfo.end).format("YYYY-MM-DD HH:mm:ss");
                    fcom.updateWithAjax(fcom.makeUrl("Teachers", "getScheduledSessions", [fecal.teacherId], confFrontEndUrl), postData, function (docs) {
                        successCallback(docs.data);
                    });
                },
            },
        ],
        select: function (arg) {
            if (checkSlotAvailabiltAjaxRun) {
                calendar.unselect();
                return false;
            }
            let slotAvailableEl = $(arg.jsEvent.target).parents(".fc-timegrid-col-frame").find(".slot_available");
            if (slotAvailableEl.length == 0) {
                calendar.unselect();
                return false;
            }
            jQuery("body #d_calendar .closeon").click();
            jQuery("#loaderCalendar").show();
            let start = moment(arg.start);
            let end = moment(arg.start).add(duration, "minutes");
            let bookingBeforeDate = moment(currentTime).add(bookingBefore, "hours");
            if (start < bookingBeforeDate || end > moment(calEndDate)) {
                jQuery("#loaderCalendar").hide();
                jQuery("body").css({cursor: "default", "pointer-events": "initial"});
                calendar.unselect();
                return false;
            }
            $.loader.show();
            checkSlotAvailabiltAjaxRun = true;
            var event = {
                start: moment(start).format("YYYY-MM-DD HH:mm:ss"),
                end: moment(end).format("YYYY-MM-DD HH:mm:ss"),
            };
            fcom.ajax(fcom.makeUrl("Teachers", "checkSlotAvailability", [fecal.teacherId], confFrontEndUrl), event, function (response) {
                checkSlotAvailabiltAjaxRun = false;
                jQuery("#loaderCalendar").hide();
                jQuery("body").css({cursor: "default", "pointer-events": "initial", });
                $.loader.hide();
                if (response.status == 0) {
                    jQuery("body > .tooltipevent").remove();
                    calendar.unselect();
                    return false;
                }
                this.getSlotBookingConfirmationBox(event, calendar);
            }, {failed: true, fOutMode: "json"});
        },
    };
    var defaultConf = this.calDefaultConf;
    var conf = {...defaultConf, ...calConf};
    var calendarEl = document.getElementById("d_calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, conf);
    calendar.render();
    jQuery("body").find(".fc-time-button").parent().html(
            "<h6><span>" + langLbl.myTimeZoneLabel + " :-</span> <span class='timer'>" + calendar.formatDate(currentTime, "hh:mm:ss {a}") +
            "</span><span class='timezoneoffset'>(" + langLbl.timezoneString + " " + this.offset + ")</span></h6>");
    seconds = 2;
    this.startTimer(currentTime, calendar);
    jQuery(".fc-today-button,button.fc-prev-button,button.fc-next-button").click(function () {
        jQuery("body > .tooltipevent").remove();
    });
    jQuery(document).bind("close.facebox", function () {
        jQuery("body > .tooltipevent").remove();
    });
};
FatEventCalendar.prototype.bookingCalendar = function (currentTime, duration, bookingBefore, days) {
    let calendarEnd = moment(currentTime).add(days, 'days').format('YYYY-MM-DD');
    let bookingBeforeDate = moment(currentTime).add(bookingBefore, 'minutes');
    var fecal = this;
    let availabilit = [];
    let bookedSession = [];
    var calConf = {
        validRange: {
            start: moment(currentTime).format('YYYY-MM-DD'),
            end: calendarEnd
        },
        views: {
            timeGridWeek: {
                titleFormat: "{LLL {d}}, yyyy",
                duration: {days: 7}
            },
        },
        now: currentTime,
        selectable: true,
        eventSources: [
            {
                events: function (fetchInfo, successCallback, failureCallback) {
                    postData = "start=" + moment(fetchInfo.start).format('YYYY-MM-DD HH:mm:ss') + "&end=" + moment(fetchInfo.end).format('YYYY-MM-DD HH:mm:ss') + "&bookingBefore=" + bookingBefore;
                    fcom.updateWithAjax(fcom.makeUrl('Teachers', 'getAvailabilityJsonData', [fecal.teacherId], confFrontEndUrl), postData, function (res) {
                        let events = [];
                        let response = res.data;
                        for (i in response) {
                            if (bookingBeforeDate >= moment(response[i].end)) {
                                continue;
                            }
                            if (moment(response[i].start) < bookingBeforeDate && moment(response[i].end) > bookingBeforeDate) {
                                response[i].start = moment(bookingBeforeDate).format('YYYY-MM-DD HH:mm:ss');
                            }
                            response[i].display = 'background';
                            response[i].selectable = true;
                            response[i].editable = false;
                            events.push(response[i]);
                        }
                        availabilit = events;
                        successCallback(events);
                    });
                }
            },
            {
                events: function (fetchInfo, successCallback, failureCallback) {
                    postData = "start=" + moment(fetchInfo.start).format('YYYY-MM-DD HH:mm:ss') + "&end=" + moment(fetchInfo.end).format('YYYY-MM-DD HH:mm:ss');
                    fcom.updateWithAjax(fcom.makeUrl('Teachers', 'getScheduledSessions', [fecal.teacherId], confFrontEndUrl), postData, function (events) {
                        bookedSession = events.data;
                        successCallback(events.data);
                    });
                }
            }
        ],
        eventClick: function (eventClickInfo) {
            let event = eventClickInfo.event;
            if (event && event.extendedProps && event.extendedProps.sessionEvent) {
                event.remove();
                delete cart.prop.slots[event.id];
                if (cart.prop.ordles_type == TYPE_SUBCRIP) {
                    $('#subcrip-checkout-btn-js').addClass('btn--disabled').removeAttr('onclick');
                }
                updateLessonList(calendar);
            }
            return true;
        },
        select: function (arg) {
            if (Object.keys(cart.prop.slots).length >= cart.prop.ordles_quantity) {
                calendar.unselect();
                return false;
            }
            let slotAvailableEl = $(arg.jsEvent.target).parents('.fc-timegrid-col-frame').find('.slot_available');
            if (slotAvailableEl.length == 0) {
                calendar.unselect();
                return false;
            }
            jQuery("#loaderCalendar").show();
            let start = moment(arg.start);
            let end = moment(arg.start).add(duration, 'minutes');
            if (start < bookingBeforeDate || end > moment(calendarEnd)) {
                jQuery("#loaderCalendar").hide();
                calendar.unselect();
                return false;
            }
            for (var dateKey in cart.prop.slots) {
                if (moment(cart.prop.slots[dateKey].ordles_starttime) < end && moment(cart.prop.slots[dateKey].ordles_endtime) > start) {
                    jQuery("#loaderCalendar").hide();
                    calendar.unselect();
                    return false;
                }
            }
            for (var keyIndex in bookedSession) {
                if (moment(bookedSession[keyIndex].start) < end && moment(bookedSession[keyIndex].end) > start) {
                    jQuery("#loaderCalendar").hide();
                    calendar.unselect();
                    return false;
                }
            }
            let canSelect = false;
            for (var availIndex in availabilit) {
                if (moment(availabilit[availIndex].start) <= start && moment(availabilit[availIndex].end) >= end) {
                    canSelect = true;
                    break;
                }
            }
            if (canSelect) {
                let eventStart = moment(start).format('YYYY-MM-DD HH:mm:ss');
                let eventEnd = moment(end).format('YYYY-MM-DD HH:mm:ss');
                let event = {
                    start: eventStart,
                    end: eventEnd,
                    display: 'block',
                    overlap: false,
                    id: moment(start).format('YYYYMMDDHHmmss'),
                    extendedProps: {
                        id: moment(start).format('YYYYMMDDHHmmss'),
                        sessionEvent: true
                    },
                };
                cart.prop.slots[event.id] = {
                    ordles_starttime: eventStart,
                    ordles_endtime: eventEnd
                };
                calendar.addEvent(event);
                if (cart.prop.ordles_type == TYPE_SUBCRIP && Object.keys(cart.prop.slots).length == cart.prop.ordles_quantity) {
                    $('#subcrip-checkout-btn-js').removeClass('btn--disabled').attr('onclick', ' cart.addSubscription();');
                }
                updateLessonList(calendar);
            }
            jQuery("#loaderCalendar").hide();
        }
    };
    var defaultConf = this.calDefaultConf;
    var conf = {...defaultConf, ...calConf};
    var calendarEl = document.getElementById("booking-calendar");
    calendar = new FullCalendar.Calendar(calendarEl, conf);
    calendar.render();
    for (id in cart.prop.slots) {
        let event = {
            start: cart.prop.slots[id].ordles_starttime,
            end: cart.prop.slots[id].ordles_endtime,
            display: 'block',
            overlap: false,
            id: id,
            extendedProps: {
                id: i,
                sessionEvent: true
            },
        };
        calendar.addEvent(event);
    }
    updateLessonList(calendar);
    jQuery('body').find(".fc-time-button").parent().html("<h6><span>" + langLbl.myTimeZoneLabel + " :-</span> <span class='timer'>" + calendar.formatDate(currentTime, 'hh:mm:ss {a}') + "</span><span class='timezoneoffset'>(" + langLbl.timezoneString + " " + this.offset + ")</span></h6>");
    seconds = 2;
    this.startTimer(currentTime, calendar);
    jQuery(".fc-today-button,button.fc-prev-button,button.fc-next-button").click(function () {
        jQuery('body > .tooltipevent').remove();
    });
    jQuery(document).bind('close.facebox', function () {
        jQuery('body > .tooltipevent').remove();
    });
};

FatEventCalendar.prototype.simpleCalendar = function (currentTime, duration, bookingBefore, days) {
    let calendarStart = moment(currentTime).format('YYYY-MM-DD');

    let bookingBeforeDate = moment().add(bookingBefore, 'minutes');

    let fecal = this;

	let teacherId = fecal.teacherId;

    var element = $('#booking');

	// remove all elements inside the element
	element.empty();

	// Header
	element.append('<div class="calender-header"><div class="calender-button to-left"><span class="fc-icon fc-icon-chevron-left"></span></div><div class="dateRange"></div><div class="calender-button to-right"><span class="fc-icon fc-icon-chevron-right"></span></div></div>');

	// handle calender button in header
	element.find('.calender-button').on('click', function () {
		if ($(this).hasClass('to-left')) {
			fecal.simpleCalendar(moment(currentTime).subtract(7, 'days').format('YYYY-MM-DD'), duration, bookingBefore, days);
		} else {
			fecal.simpleCalendar(moment(currentTime).add(7, 'days').format('YYYY-MM-DD'), duration, bookingBefore, days);
		}
	});

	// Update element.find(.dateRange) with the calendarStart and 6 days after calendarStart
	element.find('.dateRange').html(moment(calendarStart).format('DD MMM YYYY') + ' - ' + moment(calendarStart).add(6, 'days').format('DD MMM YYYY'));

	/**
	 * Add calendar list
	 */
	var calendarList = $('<div class="calendar-list"><div class="row"></div></div>');

	// Add 7 days to the calendar list
	for (var i = 0; i < 7; i++) {
		var day = $('<div class="col-sm"><div class="date"><div>' + moment(calendarStart).add(i, 'days').format('ddd') + '</div><div>' + moment(calendarStart).add(i, 'days').format('D') + '</div></div><div class="times"></div></div>');

		calendarList.find('.row').append(day);
	}

	/**
	 * Get time available for booking
	 */
	let rangeMinutes = 15;

	$.ajax({
		url: fcom.makeUrl('Teachers', 'getAvailabilityJsonData', [teacherId]),
		type: 'POST',
		dataType: 'json',
		data: {
			start: moment(currentTime).format('YYYY-MM-DD 00:00:00'),
			end: moment(currentTime).add(7, 'days').format('YYYY-MM-DD 00:00:00'),
			bookingBefore: bookingBefore,
			fOutMode: 'json',
			fIsAjax: 1
		},
		success: function (response) {
			let availableTimes = response;

			let times = [];

			$.each(availableTimes.data, function (index, value) {
				let startTime = moment(value.start);
				let endTime = moment(value.end).subtract(duration, 'minutes');

				for (let current = startTime.clone(); current.isSameOrBefore(endTime); current.add(rangeMinutes, 'minutes')) {
					if (current.isBefore(bookingBeforeDate)) continue;

					times.push(current.format('YYYY-MM-DD HH:mm:ss'));
				}
			});

			$.each(times, function (index, value) {
				let time = moment(value);

                let endTime = time.clone().add(duration, 'minutes');

				let itemDate = calendarList.find('.col-sm .date').filter(function () {
					return $(this).text().trim() == time.format('ddd') + time.format('D');
				});

				if (!itemDate) return;

				let item = itemDate.parent();

				let timeElement = $('<div class="time" data-start="' + time.format('YYYY-MM-DD HH:mm:ss') +  '" data-end="' + endTime.format('YYYY-MM-DD HH:mm:ss') +  '">' + time.format('HH:mm') + ' - ' + endTime.format('HH:mm') + '</div>');

				item.append(timeElement);
			});

			calendarList.find('.col-sm').filter(function () {
				return $(this).find('.time').length < 1;
			}).find('.date').addClass('disabled');

			// Handle time click
			calendarList.find('.col-sm .time').on('click', function () {
				let el = $(this);

				let eventStart = moment(el.data('start'));

				let eventEnd = moment(el.data('end'));

				let id = eventStart.format('YYYYMMDDHHmmss');

				if (el.hasClass('active')) {
					el.removeClass('active');

					delete cart.prop.slots[id];
				} else {
					Object.keys(cart.prop.slots).forEach(function (key) {
						let slot = cart.prop.slots[key];
						let slotStart = moment(slot.ordles_starttime);
						let slotEnd = moment(slot.ordles_endtime);

						if (eventStart.isBetween(slotStart, slotEnd) || eventEnd.isBetween(slotStart, slotEnd)) {
							delete cart.prop.slots[key];

							$('.calendar-list .time[data-start="' + slot.ordles_starttime + '"]').removeClass('active');
						}
					});

					let event = {
						start: eventStart.format('YYYY-MM-DD HH:mm:ss'),
						end: eventEnd.format('YYYY-MM-DD HH:mm:ss'),
						display: 'block',
						overlap: false,
						id: id,
						extendedProps: {
							id: id,
							sessionEvent: true
						},
					};

					cart.prop.slots[event.id] = {
						ordles_starttime: event.start,
						ordles_endtime: event.end
					};

					if (Object.keys(cart.prop.slots).length > cart.prop.ordles_quantity) {
						let slot = cart.prop.slots[Object.keys(cart.prop.slots)[0]];

						$('.calendar-list .time[data-start="' + slot.ordles_starttime + '"]').removeClass('active');

						delete cart.prop.slots[Object.keys(cart.prop.slots)[0]];
					}

					el.addClass('active');
				}
			});

			// Handle selected item
			Object.keys(cart.prop.slots).forEach(function (key) {
				let slot = cart.prop.slots[key];

				$('.calendar-list .time[data-start="' + slot.ordles_starttime + '"]').addClass('active');
			});
		}
	});

	element.append(calendarList);
};

FatEventCalendar.prototype.simpleCalendarTrial = function (currentTime, duration, bookingBefore, selectable) {
    let calendarStart = moment(currentTime).format('YYYY-MM-DD');

    let bookingBeforeDate = moment().add(bookingBefore, 'minutes');

    let fecal = this;

	let teacherId = fecal.teacherId;

    var element = $('#' + (selectable ? "d_calendarfree_trial" : "d_calendar"));

    var checkSlotAvailabiltAjaxRun = false;

	// remove all elements inside the element
	element.empty();

	// Header
	element.append('<div class="calender-header"><div class="calender-button to-left"><span class="fc-icon fc-icon-chevron-left"></span></div><div class="dateRange"></div><div class="calender-button to-right"><span class="fc-icon fc-icon-chevron-right"></span></div></div>');

	// handle calender button in header
	element.find('.calender-button').on('click', function () {
		if ($(this).hasClass('to-left')) {
			fecal.simpleCalendarTrial(moment(currentTime).subtract(7, 'days').format('YYYY-MM-DD'), duration, bookingBefore, selectable);
		} else {
			fecal.simpleCalendarTrial(moment(currentTime).add(7, 'days').format('YYYY-MM-DD'), duration, bookingBefore, selectable);
		}
	});

	// Update element.find(.dateRange) with the calendarStart and 6 days after calendarStart
	element.find('.dateRange').html(moment(calendarStart).format('DD MMM YYYY') + ' - ' + moment(calendarStart).add(6, 'days').format('DD MMM YYYY'));

	/**
	 * Add calendar list
	 */
	var calendarList = $('<div class="calendar-list"><div class="row"></div></div>');

	// Add 7 days to the calendar list
	for (var i = 0; i < 7; i++) {
		var day = $('<div class="col-sm"><div class="date"><div>' + moment(calendarStart).add(i, 'days').format('ddd') + '</div><div>' + moment(calendarStart).add(i, 'days').format('D') + '</div></div><div class="times"></div></div>');

		calendarList.find('.row').append(day);
	}

	/**
	 * Get time available for booking
	 */
	let rangeMinutes = 15;

	$.ajax({
		url: fcom.makeUrl('Teachers', 'getAvailabilityJsonData', [teacherId]),
		type: 'POST',
		dataType: 'json',
		data: {
			start: moment(currentTime).format('YYYY-MM-DD 00:00:00'),
			end: moment(currentTime).add(7, 'days').format('YYYY-MM-DD 00:00:00'),
			bookingBefore: bookingBefore,
			fOutMode: 'json',
			fIsAjax: 1
		},
		success: function (response) {
			let availableTimes = response;

			let times = [];

			$.each(availableTimes.data, function (index, value) {
				let startTime = moment(value.start);
				let endTime = moment(value.end).subtract(duration, 'minutes');

				for (let current = startTime.clone(); current.isSameOrBefore(endTime); current.add(rangeMinutes, 'minutes')) {
					if (current.isBefore(bookingBeforeDate)) continue;

					times.push(current.format('YYYY-MM-DD HH:mm:ss'));
				}
			});

			$.each(times, function (index, value) {
				let time = moment(value);

                let endTime = time.clone().add(duration, 'minutes');

				let itemDate = calendarList.find('.col-sm .date').filter(function () {
					return $(this).text().trim() == time.format('ddd') + time.format('D');
				});

				if (!itemDate) return;

				let item = itemDate.parent();

				let timeElement = $('<div class="time" data-start="' + time.format('YYYY-MM-DD HH:mm:ss') +  '" data-end="' + endTime.format('YYYY-MM-DD HH:mm:ss') +  '">' + time.format('HH:mm') + ' - ' + endTime.format('HH:mm') + '</div>');

				item.append(timeElement);
			});

			calendarList.find('.col-sm').filter(function () {
				return $(this).find('.time').length < 1;
			}).find('.date').addClass('disabled');

			// Handle time click
			calendarList.find('.col-sm .time').on('click', function () {
				let el = $(this);
				let start = moment(el.data('start'));

                jQuery("body #d_calendar .closeon").click();
                jQuery("#loaderCalendar").show();
                if (checkSlotAvailabiltAjaxRun) {
                    return false;
                }
                let end = moment(el.data('start')).add(duration, "minutes");
                let bookingBeforeDate = moment(currentTime).add(bookingBefore, "hours");
                if (start < bookingBeforeDate) {
                    jQuery("#loaderCalendar").hide();
                    jQuery("body").css({cursor: "default", "pointer-events": "initial"});
                    return false;
                }
                $.loader.show();
                checkSlotAvailabiltAjaxRun = true;
                let event = {
                    start: start.format("YYYY-MM-DD HH:mm:ss"),
                    end: end.format("YYYY-MM-DD HH:mm:ss"),
                };
                fcom.updateWithAjax(fcom.makeUrl("Teachers", "checkSlotAvailability", [fecal.teacherId]), event, function (res) {
                    $.loader.hide();
                    checkSlotAvailabiltAjaxRun = false;
                    jQuery("#loaderCalendar").hide();
                    jQuery("body").css({cursor: "default", "pointer-events": "initial", });
                    if (res.status == 0) {
                        jQuery("body > .tooltipevent").remove();
                        return;
                    }
                    this.getSimpleCalendarSlotBookingConfirmationBox(event, true);
                }, {failed: true});
			});

			// Handle selected item
			Object.keys(cart.prop.slots).forEach(function (key) {
				let slot = cart.prop.slots[key];

				$('.calendar-list .time[data-start="' + slot.ordles_starttime + '"]').addClass('active');
			});
		}
	});

	element.append(calendarList);
};
