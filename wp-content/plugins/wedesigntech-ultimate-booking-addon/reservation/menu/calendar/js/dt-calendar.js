jQuery(document).ready(function($){
    "use strict";

	var $calendar_wrapper = $('div#dt-calendar-wrapper');
    var $calendar = $calendar_wrapper.find('div.dt-calendar');
    var $endTimeField = $("select[name='end']");
    var $endTimeOptions = $endTimeField.find("option");
    var $timestampsOfOptions = {start:[],end:[]};

    /* Calendar Init() */
    $calendar.weekCalendar({
    	timeslotsPerHour: 4,
        timeslotHeight: 30,
        hourLine: true,
        scrollToHourMillis : 0,
        businessHours: {start: 8, end: 19},
        useShortDayNames:true,
        displayFreeBusys: true,
        daysToShow: 7,
        switchDisplay: {'1 day': 1, '3 next days': 3, 'work week': 5, 'full week': 7, '15 next days':15 , },
        height: function($calendar) {
            return $(window).height()-100;
        },
        data: function(start, end, callback) {
            $.ajax({
                type:'post',
                url: ajaxurl,
                data: {
                    action: 'dt_list_member_reservations' ,
                    id: $("ul#dt-members-list li a.active").data('memberid'),
                    start: start.getFullYear()+'/'+(start.getMonth()+1)+'/'+start.getDate(),
                    end: end.getFullYear()+'/'+(end.getMonth()+1)+'/'+end.getDate()
                },
                dataType:'json',
                success: function(response) {

                    var reservations = $.map( response.events, function(value){
                        return {
                            id : parseInt(value.id, 10),
                            start: new Date(value.start),
                            end: new Date(value.end),
                            title:value.title,
                            body:value.body,
                            readOnly: ( value.readOnly == 1 ) ? false : true
                        };
                    });

                    var freebusys = $.map( response.freebusys, function(value){
                        return {
                            start: new Date(value.start),
                            end: new Date(value.end),
                            free: value.free
                        }
                    });
                    callback({ events: reservations , freebusys: freebusys});
                }
            });
        },

        eventNew: function(calEvent, $event) {
            var $dialogContent = $("#event_edit_container");
            resetForm($dialogContent);

            var startField = $dialogContent.find("select[name='start']").val(calEvent.start);

            var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
            var titleField = $dialogContent.find("input[name='title']");
            var bodyField = $dialogContent.find("textarea[name='body']");
            var memberId = $dialogContent.find("input[name='member_id']");
            var servicesField = $dialogContent.find("select[name='service']");
            var customersField = $dialogContent.find("select[name='customer']");

            $dialogContent.dialog({
                modal: true,
                title: reservation.new_event,
                close: function() {
                    $dialogContent.dialog("destroy");
                    $dialogContent.hide();
                    $calendar.weekCalendar("removeUnsavedEvents");
                },
                buttons: {
                    save : function() {
                        $.ajax({
                            type:'post',
                            url:ajaxurl,
                            data: {action:'dt_new_reservation_id'},
                            complete: function(response){

                                var id = response.responseText;
                                calEvent.id = id;
                                calEvent.start = new Date(startField.val());
                                calEvent.end = new Date(endField.val());
                                calEvent.title = titleField.val();
                                calEvent.body = bodyField.val();
                                calEvent.service = servicesField.val();
                                calEvent.customer = customersField.val();

                                var option = '_dt_reservation_mid_'+memberId.val()+'_id_'+id

                                var start = calEvent.start;
                                var end = calEvent.end;

                                $.ajax({
                                    type:'post',
                                    url:ajaxurl,
                                    dataType:'json',
                                    data:{
                                            action:   'dt_add_new_reservation',
                                            id:       id,
                                            title:    calEvent.title,
                                            body:     calEvent.body,
                                            service:  calEvent.service,
                                            user:     calEvent.customer,
                                            memberid: memberId.val(),
                                            start:    start.getFullYear() +"/"+(start.getMonth()+1)+"/"+start.getDate()+" "+start.getHours()+":"+start.getMinutes(),
                                            end:      end.getFullYear() +"/"+(end.getMonth()+1)+"/"+end.getDate()+" "+end.getHours()+":"+end.getMinutes(),
                                            option:   option,

                                            c_start:  start.getFullYear()+'/'+( start.getMonth()+1 )+'/'+start.getDate()+" "+start.getHours()+':'+start.getMinutes(),
                                            //Mailing Purpose
                                            date:     start.getFullYear()+'/'+( start.getMonth()+1 )+'/'+start.getDate() , // mail purpose
                                            time:     $calendar.weekCalendar("formatTime", calEvent.start) + " - "+ $calendar.weekCalendar("formatTime", calEvent.end),
                                            //Mailing Purpose
                                    },
                                    success: function(response) {
                                        calEvent.end = response.data.end;
                                    },
                                    complete: function(response){
                                        $calendar.weekCalendar("removeUnsavedEvents");
                                        $calendar.weekCalendar("updateEvent", calEvent);
                                    }
                                });
                            }
                        });

                        $dialogContent.dialog("close");
                    },
                    cancel : function() {
                        $dialogContent.dialog("close");
                    }
                }
            }).show();

            $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
            $dialogContent.find("input[name='member_id']").attr('value', $("ul#dt-members-list li a.active").data('memberid'));
            setupServiceField( servicesField, $("ul#dt-members-list li a.active").data('memberid'));
            setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));

        },
        eventClick: function(calEvent, $event) {

            if (calEvent.readOnly) {
                return;
            }

            var $dialogContent = $("#event_edit_container");
            resetForm($dialogContent);

            var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
            var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
            var titleField = $dialogContent.find("input[name='title']").val(calEvent.title);
            var bodyField = $dialogContent.find("textarea[name='body']");
            bodyField.val(calEvent.body);
            var memberId = $dialogContent.find("input[name='member_id']");
            var servicesField = $dialogContent.find("select[name='service']");
            var customersField = $dialogContent.find("select[name='customer']");

            var option = '_dt_reservation_mid_'+$("ul#dt-members-list li a.active").data('memberid')+'_id_'+calEvent.id;


            $dialogContent.dialog({
                modal: true,
                title: reservation.edit+ " - "+ calEvent.title,
                close: function() {
                    $dialogContent.dialog("destroy");
                    $dialogContent.hide();
                    $calendar.weekCalendar("removeUnsavedEvents");
                },
                buttons: {
                    "Update" : function(){

                        calEvent.start = new Date(startField.val());
                        calEvent.end = new Date(endField.val());
                        calEvent.title = titleField.val();
                        calEvent.body = bodyField.val();

                        var start = calEvent.start;
                        var end = calEvent.end;
                        var id = calEvent.id;

                        /* Edit Event */
                        $.ajax({
                            type:'post',
                            url:ajaxurl,
                            dataType:'json',
                            data:{
                                action:   'dt_update_reservation',
                                id:       id,
                                title:    calEvent.title,
                                body:     calEvent.body,
                                service:  servicesField.val(),
                                memberid: memberId.val(),
                                user: customersField.val(),
                                option:   option,
                                start:    start.getFullYear() +"/"+(start.getMonth()+1)+"/"+start.getDate()+" "+start.getHours()+":"+start.getMinutes(),
                                end:      end.getFullYear() +"/"+(end.getMonth()+1)+"/"+end.getDate()+" "+end.getHours()+":"+end.getMinutes(),
                                c_start:  start.getFullYear()+'/'+( start.getMonth()+1 )+'/'+start.getDate()+" "+start.getHours()+':'+start.getMinutes(),

                                //Mailing Purpose
                                date:     start.getFullYear()+'/'+( start.getMonth()+1 )+'/'+start.getDate(),
                                time:     $calendar.weekCalendar("formatTime", calEvent.start) + " - "+ $calendar.weekCalendar("formatTime", calEvent.end),
                                //Mailing Purpose
                            },
                            success: function(response) {
                                calEvent.end = response.data.end;
                            },
                            complete: function( response ){
                                $calendar.weekCalendar("updateEvent", calEvent);
                            }
                        });
                        /* Edit Event End */
                        $dialogContent.dialog("close");
                    },

                    'delete': function(){
                        calEvent.start = new Date(startField.val());
                        calEvent.end = new Date(endField.val());
                        calEvent.title = titleField.val();
                        calEvent.body = bodyField.val();

                        var start = calEvent.start;
                        var end = calEvent.end;
                        var id = calEvent.id;

                        /* Delete Event */
                        $.ajax({
                            type: 'post',
                            url:ajaxurl,
                            data:{
                                action:   'dt_delete_reservation',
                                id:       id,
                                title:    calEvent.title,
                                body:     calEvent.body,
                                service:  servicesField.val(),
                                memberid: memberId.val(),
                                option:   option,
                                start:    start.getFullYear() +"/"+(start.getMonth()+1)+"/"+start.getDate()+" "+start.getHours()+":"+start.getMinutes(),
                                end:      end.getFullYear() +"/"+(end.getMonth()+1)+"/"+end.getDate()+" "+end.getHours()+":"+end.getMinutes(),

                                //Mailing Purpose
                                date:     start.getFullYear()+'/'+( start.getMonth()+1 )+'/'+start.getDate(),
                                time:     $calendar.weekCalendar("formatTime", calEvent.start) + " - "+ $calendar.weekCalendar("formatTime", calEvent.end),
                                //Mailing Purpose
                            },
                            complete: function( response ){
                                $calendar.weekCalendar("removeEvent", calEvent.id);
                            }
                        });
                        /* Delete Event */
                        $dialogContent.dialog("close");
                    },
                    cancel: function(){
                        $dialogContent.dialog("close");
                    }
                }
            }).show();

            var startField = $dialogContent.find("select[name='start']").val(calEvent.start);
            var endField = $dialogContent.find("select[name='end']").val(calEvent.end);
            $dialogContent.find(".date_holder").text($calendar.weekCalendar("formatDate", calEvent.start));
            $dialogContent.find("input[name='member_id']").attr('value', $("ul#dt-members-list li a.active").data('memberid'));
            setupServiceField( servicesField, $("ul#dt-members-list li a.active").data('memberid') , option );
            setupCustomerField( customersField,option );
            setupStartAndEndTimeFields(startField, endField, calEvent, $calendar.weekCalendar("getTimeslotTimes", calEvent.start));

        },
    });
    /* Calendar Init() */

    /* Utilities */
    function resetForm($dialogContent) {
        $dialogContent.find("input").val("");
        $dialogContent.find("textarea").val("");
    }

    function setupStartAndEndTimeFields($startTimeField, $endTimeField, calEvent, timeslotTimes) {
        $startTimeField.empty();
        $endTimeField.empty();

        for (var i = 0; i < timeslotTimes.length; i++) {
            var startTime = timeslotTimes[i].start;
            var endTime = timeslotTimes[i].end;
            var startSelected = "";

            if (startTime.getTime() === calEvent.start.getTime()) {
                startSelected = "selected=\"selected\"";
            }

            var endSelected = "";
            if (endTime.getTime() === calEvent.end.getTime()) {
                endSelected = "selected=\"selected\"";
            }

            $startTimeField.append("<option value=\"" + startTime + "\" " + startSelected + ">" + timeslotTimes[i].startFormatted + "</option>");
            $endTimeField.append("<option value=\"" + endTime + "\" " + endSelected + ">" + timeslotTimes[i].endFormatted + "</option>");

            $timestampsOfOptions.start[timeslotTimes[i].startFormatted] = startTime.getTime();
            $timestampsOfOptions.end[timeslotTimes[i].endFormatted] = endTime.getTime();
        }

        $endTimeOptions = $endTimeField.find("option");
        $startTimeField.trigger("change");
    }


    function setupServiceField( $field, $memberid , $option ){
        $field.empty();
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:{ action:'dt_load_services', memberid: $memberid, option : $option  },
            dataType:'html',
            success: function( response ){
                $field.append(response);
            }
        });
    }

    function setupCustomerField( $customersField, $option ){
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:{ action:'dt_set_customer', option : $option  },
            dataType:'html',
            success: function( response ){
               $customersField.find("option[value='" + response + "']").prop("selected", true);
            }
        });
    }

    //reduces the end time options to be only after the start time options.
    $("select[name='start']").change(function() {
        var startTime = $timestampsOfOptions.start[$(this).find(":selected").text()];
        var currentEndTime = $endTimeField.find("option:selected").val();
        $endTimeField.html( $endTimeOptions.filter(function() { return startTime < $timestampsOfOptions.end[$(this).text()]; }) );
        var endTimeSelected = false;

        $endTimeField.find("option").each(function() {
            if ($(this).val() === currentEndTime) {
                $(this).prop("selected", true);
                endTimeSelected = true;
                return false;
            }
        });

        if (!endTimeSelected) {
            //automatically select an end date 2 slots away.
            $endTimeField.find("option:eq(1)").prop("selected", true);
        }
    });

    $("ul#dt-members-list li").find("a").on('click', function(){
        $("ul#dt-members-list li a").removeClass('active');
        $(this).addClass('active');
        $calendar.weekCalendar();
        $calendar.weekCalendar('refresh');
        return false;
    });
    /* Utilities */
});