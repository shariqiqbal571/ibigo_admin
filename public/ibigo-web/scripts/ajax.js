$(document).ready(function() {
    var information = $('.information');
    $.ajax({
        url: "/information/" + 1,
        type: "GET",
        data: { id: 1 },
        // dataType: 'JSON',
        success: function(res) {
            $(res.pages).each(function(index) {
                // console.log(this);
                information.append('<a href="/pages/' + this.page_unique_id + '/' + this.page_slug + '" class="ng-star-inserted"><i class="fas fa-circle  bg-magenta-dark"></i><span>' + this.page_title + '</span></a>')
            })
        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
});

function getSpot() {
    var searching = $('.search').val();
    var spots = $('.allData');
    spots.children().remove();
    $.ajax({
        url: "/web/search",
        type: "GET",
        data: { search: searching },
        dataType: 'JSON',
        success: function(res) {
            $(res.data).each(function(index) {
                // console.log(this);
                // console.log(this.spot_profile);
                // console.log(this.full_address);
                spots.css('display', 'block');
                spots.append('<div class="all-spots pt-2 pl-3" onclick="singleSpot(this.children[0])"><input type="hidden" class="spotId" value="' + this.id + '" /><div class="row"><div class="col-sm-2 mb-auto"><img src="' + this.user_spot.user_profile + '" width="70" height="70" /></div><div class="col-sm-10 mt-auto"><h4>' + this.business_name + '</h4><p>' + this.full_address + '</p></div> </div></div>');
            });
            // console.log(res);
            // alert(res);

        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
    if (searching === '' || searching === null) {
        spots.css('display', 'none');
    }
};

$(document).ready(function() {


    $(".comment-section").click(function() {
        $(this).parent('.comment-parent').siblings('.comment-box').toggle();
    });


    $('.heart').click(function() {
        $(this).children('.border-heart').toggle()
        $(this).children('.filled-heart').toggle()
    });
});

function singleSpot(event) {
    var spotId = event.value;
    var spots = $('.allData');
    spots.css('display', 'none');
    spots.children().remove();
    var selectSpot = $('.select-spot');
    selectSpot.children().remove();
    $.ajax({
        url: '/findspot/' + spotId,
        type: 'GET',
        data: { id: spotId },
        dataType: 'JSON',
        success: function(res) {
            selectSpot.css('display', 'block');
            var desc = ' ';
            if (res.search[0].short_description) {
                desc = res.search[0].short_description;
            }
            selectSpot.append('<div class="single-spot"><input type="hidden" name="spot_id" value="' + res.search[0].id + '" /><div class="row m-0 p-2"><div class="col-sm-2 my-auto"><img src="' + res.search[0].user_spot.user_profile + '" width="100" height="100" /></div><div class="col-sm-8 my-auto"><h4>' + res.search[0].business_name + '</h4><p>' + desc + '</p><p class="d-flex">Like By<span class="user-images ml-2"></span></p></div><div class="col-sm-2 m-auto"><div class="bg-success rounded"><p class="text-center text-light mt-2">' + res.search[0].rating + '</p></div></div></div></div>');
            var images = $('.user-images');
            $(res.search[0].spot_detail).each(function(index) {
                if (this.like === 1) {
                    if (this.user.user_profile) {
                        images.append('<img src="storage/images/user/profile/' + this.user.user_profile + '" width="50" height="50" class="rounded-circle" />');
                    }
                }
            })
            console.log(res);
        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
    // console.log(spotId);

};

$('#searchFriends').click(function() {
    // console.log('Hello');
    var taggedUsers = $(this).siblings('#inputTagged').val();
    var dropMenuTag = $(this).parent('#searchInput').siblings('.drop-menu-tag');
    dropMenuTag.children().remove();
    $.ajax({
        url: '/find-friends',
        type: 'GET',
        data: { taggedUsers: taggedUsers },
        dataType: 'JSON',
        success: function(res) {
            // console.log(res);
            $(res.friends).each(function() {
                dropMenuTag.show();
                dropMenuTag.append('<a class="dropdown-item d-flex" onclick="addUser(this.children)" href="#"><input type="hidden" value="' + this.id + '" /><img src="storage/images/user/profile/' + this.user_profile + '" width="50" height="50" class="rounded-circle" /><p class="mb-0">' + this.fullname + '</p> </a>')
            });
        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
});

function addUser(event) {
    var id = event[0].value;
    var name = event[2].innerHTML;
    console.log(id);
    console.log(name);
    var dropMenuTag = $('.drop-menu-tag');
    dropMenuTag.hide();
    var tagFriends = $('.tag-users');
    tagFriends.show();
    tagFriends.children('.inner-tag-users').append('<div class="col-lg-4 col-md-6 col-sm-12 mb-0 alert alert-success alert-dismissible fade show" role="alert">' + name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><input type="hidden" name="tagged_user_id[]" value="' + id + '" /></div>')

};


$('.friends').click(function() {
    var friendName = $(this).children('.friend-name').children().text();
    var friendId = $(this).children('.friend-id').val();
    var checkMember = $(this).siblings('.make-admin').children('.user-group');

    if (checkMember.text() == 'Admin') {
        var memberOrAdmin = 'admin_id';
    } else {
        var memberOrAdmin = 'tagged_user_id';
    }
    console.log(friendName);
    console.log(friendId);
    var invitePeople = $('.invite-people');
    invitePeople.children('.row').append('<div class="col-lg-6 my-1 px-2 position-relative col-md-6 col-sm-12 mb-0 alert alert-success alert-dismissible fade show" role="alert">' + friendName + '<button type="button" style="top:50% !important;;right:-10px !important;" class="close show-friend" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><input type="hidden" name="' + memberOrAdmin + '[]" value="' + friendId + '" /></div>')
    var friend = $(this);
    friend.hide();
    friend.siblings('.make-admin').hide();
    $('.show-friend').click(function() {
        friend.show();
        friend.siblings('.make-admin').show();
    });
});

$('.groups').click(function() {
    var friendName = $(this).children('.group-name').children().text();
    var friendId = $(this).children('.group-id').val();

    var invitePeople = $('.invite-people');
    invitePeople.children('.row').append('<div class="col-lg-6 my-1 px-2 position-relative col-md-6 col-sm-12 mb-0 alert alert-success alert-dismissible fade show" role="alert">' + friendName + '<button type="button" style="top:50% !important;;right:-10px !important;" class="close show-friend" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><input type="hidden" name="group_id[]" value="' + friendId + '" /></div>')
    var friend = $(this);
    friend.hide();
    $('.show-friend').click(function() {
        friend.show();
    });
});

$('.spots').click(function() {
    var spotName = $(this).children('.spot-name').children().text();
    var spotId = $(this).children('.spot-id').val();
    console.log(spotName);
    console.log(spotId);
    var invitePeople = $('.spots-evetns');
    invitePeople.show();
    invitePeople.children('.row').append('<div class="col-lg-12 my-1 px-2 position-relative col-md-12 col-sm-12 mb-0 alert alert-success alert-dismissible fade show" role="alert">' + spotName + '<button type="button" style="top:50% !important;;right:-10px !important;" class="close show-spot" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><input type="hidden" name="spot_id[]" value="' + spotId + '" /></div>')
    var spot = $(this);
    spot.hide();
    $('.show-spot').click(function() {
        spot.show();
    });
});

$('.all-spots').click(function() {
    var spotImage = $(this).children('.spot-image').children().attr('src');
    var spotName = $(this).children('.spot-name').children().text();
    var spotId = $(this).children('.spot-id').val();
    console.log(spotImage);
    console.log(spotName);
    console.log(spotId);
    var selectedSpot = $('.selected-spot');
    selectedSpot.show();
    var invitePeople = $('.single-spot');
    invitePeople.show();
    invitePeople.children('.row').children().remove();
    invitePeople.children('.row').append('<div class="col-lg-12 my-1 px-0 position-relative col-md-12 col-sm-12 mb-0 alert alert-dismissible fade show" role="alert"><img src="' + spotImage + '" alt="" width="50" height="50" class="rounded-circle mr-3">' + spotName + '<button type="button" style="top:50% !important;;right:-10px !important;" class="close show-spot" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><input type="hidden" name="spot_id" value="' + spotId + '" /></div>')
    $('.show-spot').click(function() {
        selectedSpot.hide();
        invitePeople.hide();
    });
});


$('#group-name').keyup(function() {
    $('#create-btn').show();
});

function imageUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#upload-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        $('.imagesrcblock').css('display', 'block');
    }
}
$(".upload-image").change(function() {
    imageUpload(this);
});

function groupProfile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#upload-profile').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        $('.imagesrcprofile').css('display', 'block');
    }
}
$(".upload-profile").change(function() {
    groupProfile(this);
});

$('.time-up').click(function() {
    var timeHours = $(this).parent().siblings('.time-hours').children('.time-hours-input');
    var num = parseInt(timeHours.val());
    if (timeHours.val() == 'HH') {
        timeHours.val('0' + 0);
    } else if (timeHours.val() < 9) {
        num++;
        timeHours.val('0' + num);
    } else if (timeHours.val() == 23) {
        timeHours.val('0' + 0);
    } else {
        num++;
        timeHours.val(num);
    }
});


$('.time-down').click(function() {
    var timeHours = $(this).parent().siblings('.time-hours').children('.time-hours-input');
    var num = parseInt(timeHours.val());
    if (timeHours.val() == 'HH') {
        timeHours.val(23);
    } else if (num < 01) {
        num = 23;
        timeHours.val(num);
    } else if (timeHours.val() < 11) {
        num--;
        timeHours.val('0' + num);
    } else {
        num--;
        timeHours.val(num);
    }
});


$('.time-up-2').click(function() {
    var timeMins = $(this).parent().siblings('.time-mins').children('.time-mins-input');
    var num = parseInt(timeMins.val());
    if (timeMins.val() == 'MM') {
        timeMins.val('0' + 0);
    } else if (num == 00) {
        num = num + 15;
        timeMins.val(num);
    } else if (timeMins.val() == 45) {
        timeMins.val('0' + 0);
        var timeHours = $(this).parent().parent().parent().siblings('.time').children().children('.time-hours').children('.time-hours-input');

        var num2 = parseInt(timeHours.val());
        if (timeHours.val() == 'HH') {
            timeHours.val('0' + 1);
        } else if (timeHours.val() < 9) {
            num2++;
            timeHours.val('0' + num2);
        } else if (timeHours.val() == 23) {
            timeHours.val('0' + 0);
        } else {
            num2++;
            timeHours.val(num2);
        }

    } else {
        num = num + 15;
        timeMins.val(num);
    }
});


$('.time-down-2').click(function() {
    var timeMins = $(this).parent().siblings('.time-mins').children('.time-mins-input');
    var num = parseInt(timeMins.val());
    if (timeMins.val() == 'MM') {
        timeMins.val(45);
    } else if (num == 00) {
        timeMins.val(45);
    } else if (timeMins.val() == 15) {
        num = num - 15;
        timeMins.val('0' + num);

        var timeHours = $(this).parent().parent().parent().siblings('.time').children().children('.time-hours').children('.time-hours-input')
        var num2 = parseInt(timeHours.val());
        if (timeHours.val() == 'HH') {
            timeHours.val(23);
        } else if (num2 < 01) {
            num2 = 23;
            timeHours.val(num2);
        } else if (timeHours.val() < 11) {
            num2--;
            timeHours.val('0' + num2);
        } else {
            num2--;
            timeHours.val(num2);
        }
    } else {
        num = num - 15;
        timeMins.val(num);
    }
});

$('.checkedOrNot').click(function() {
    console.log('work');
    if ($(this).is(':checked')) {
        $(this).siblings('.check-it').addClass('bg-black');
        $(this).siblings('.check-it').removeClass('bg-light');
        $(this).siblings('a').addClass('bg-black');
        $(this).siblings('a').removeClass('bg-gray-light');
        $(this).siblings('a').addClass('color-white');
        $(this).siblings('a').removeClass('color-black');
    } else {
        $(this).siblings('.check-it').removeClass('bg-black');
        $(this).siblings('.check-it').addClass('bg-light');
        $(this).siblings('a').removeClass('bg-black');
        $(this).siblings('a').addClass('bg-gray-light');
        $(this).siblings('a').removeClass('color-white');
        $(this).siblings('a').addClass('color-black');
    }
});



$(document).ready(function() {
    $('.like').click(function() {


        $('.likeit').css("display", "block");
        $('.like').css("display", "none");

    });

    $('.likeit').click(function() {

        $('.like').css("display", "block");
        $('.likeit').css("display", "none");
    });

    //Connected and Connect query

    $('.Connected').click(function() {


        $('.Connect').css("display", "block");
        $('.Connected').css("display", "none");

    });

    $('.Connect').click(function() {

        $('.Connected').css("display", "block");
        $('.Connect').css("display", "none");
    });
});

$(document).ready(function() {
    $('.tab-2').click(function() {
        console.log($(this));
        $('#group-btn').css('opacity', 1);
    });

    $('.groupactive').click(function() {
        $('.creategroup').css("display", "block");
    });

    $('.friendactive').click(function() {
        $('.creategroup').css("display", "none");
    });

    $('.spotactive').click(function() {
        $('.creategroup').css("display", "none");
    });

    //Plan button
    $('.groupplanactive').click(function() {
        $('.createplane').css("display", "none");
    });

    $('.friendplanactive').click(function() {
        $('.createplane').css("display", "none");
    });

    $('.spotplanactive').click(function() {
        $('.createplane').css("display", "block");
    });
});


$(function() {
    $("#datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        duration: "fast"
    });
    $("#datepicker1").datepicker({
        dateFormat: "dd-mm-yy",
        duration: "fast"
    });
    $("#datepicker2").datepicker({
        dateFormat: "dd-mm-yy",
        duration: "fast"
    });
    $("#datepicker3").datepicker({
        dateFormat: "dd-mm-yy",
        duration: "fast"
    });
    $("#datepicker4").datepicker({
        dateFormat: "dd-mm-yy",
        duration: "fast"
    });
});

function chat(userId) {
    var authId = $('.authId').val();
    var chatMsg = $('.chat-messgaes');
    chatMsg.children().remove();
    $.ajax({
        url: "/single-chat/" + userId,
        type: "GET",
        dataType: 'JSON',
        success: function(res) {
            $(res.message).each(function(index) {
                if (this.message_date == undefined || this.message_date == '' || this.message_date == null) {
                    var date = '';
                } else {
                    var date = '<p class="font-10 text-center">' + this.message_date + '</p>';
                }
                if (this.from_user_id == authId) {
                    var messages = date + '<div class="speech-bubble speech-left bg-magenta-dark mb-0">' + this.message + '</div><div class="clearfix"></div><p class="font-10 text-right">' + this.message_time + '</p>';
                } else {
                    var messages = date + '<div class="speech-bubble speech-right color-black mb-0">' + this.message + '</div><div class="clearfix"></div><p class="font-10 text-left">' + this.message_time + '</p>';
                }
                chatMsg.append(messages + '<div class="clearfix"></div>');

            });
            console.log(res);
        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
    chatMsg.append('<input type="hidden" id="userId" value="' + userId + '"  >');
    $(".chat-messgaes").animate({
        scrollTop: $(
            '.chat-messgaes').get(0).scrollHeight
    }, 100);
}

$('.show-msg-box').click(function() {
    var userId = $(this).children('.userId').val();
    $('#msg-box').show();
    $("#empty-msg-box").hide();
    $("#footer-bar").show();
    $('.hide-it').hide();
    chat(userId);
});


$('.message-btn').click(function() {
    var userId = $('#userId').val();
    var msgBox = $(this).parent().siblings().children('.message-box').val();
    var userId = $(this).parents('.page').siblings('.container').children('.row').children('.col-lg-8').children('#msg-box').children('.chat-messgaes').children('#userId').val();
    $.ajax({
        url: "/message-send",
        type: "GET",
        data: { message: msgBox, user_id: userId },
        dataType: 'JSON',
        success: function(res) {
            console.log(res);
        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
    chat(userId);
    $(this).parent().siblings().children('.message-box').val('');
})

$(document).ready(function() {
    $('.voegtoeActive').css("display", "block");
});

$(".golistActive").click(function() {
    $('.voegtoeActive').css("display", "block");
    $('.planutijeActive').css("display", "none");
});

$(".agendaActive").click(function() {
    $('.planutijeActive').css("display", "block");
    $('.voegtoeActive').css("display", "none");
});

$(function() {
    $("#datepicker2").datepicker({
        dateFormat: "dd-mm-yy",
        duration: "fast"
    });
});


$(document).ready(function() {
    $(".comment-section").click(function() {
        $(this).parent('.comment-parent').siblings('.comment-box').toggle();
    });


    $('.heart').click(function() {
        $(this).children('.border-heart').toggle()
        $(this).children('.filled-heart').toggle()
    });
});

$(".kiesVrienden").click(function() {
    $('.selectkiesVrienden').toggle();
});

$('.noti').click(function() {
    // console.log("Click")
    var notiId = $(this).children('.notiId').val();
    $.ajax({
        url: "/notification-status/" + notiId,
        type: "GET",
        success: function(res) {
            console.log("okay" + res);
        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
})

$('.cover').change(function() {
    if (this.files && this.files[0]) {
        // var reader = new FileReader();
        console.log(this.files[0].name);

        // reader.onload = function(e) {
        $.ajax({
            url: "/upload-cover",
            type: "GET",
            data: { user_cover: this.files[0].name },
            dataType: 'JSON',
            success: function(res) {
                console.log(res);
                location.reload();
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
    }
})

$('#btn').change(function() {
    $(this).parent().siblings('.upload-btn').show();
    $(this).parent().hide();
})

$('.specific-friends').click(function() {
    if ($(this).val() == 2) {
        $('.select-friends').show();
    } else {
        $('.select-friends').hide();
    }
})

$('#inputspecific').keyup(function(e) {
    var search = $(this).val();
    var dropMenuTag = $(this).parent('#searchInputSpecific').siblings('.drop-menu-specific');
    dropMenuTag.children().remove();
    $.ajax({
        url: '/find-friends',
        type: 'GET',
        data: { taggedUsers: search },
        dataType: 'JSON',
        success: function(res) {
            // console.log(res);
            $(res.friends).each(function() {
                dropMenuTag.show();
                dropMenuTag.append('<a class="dropdown-item d-flex" onclick="addSpecific(this.children)" href="#"><input type="hidden" value="' + this.id + '" /><img src="storage/images/user/profile/' + this.user_profile + '" width="50" height="50" class="rounded-circle" /><p class="mb-0">' + this.fullname + '</p> </a>')
            });
        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
})

function addSpecific(event) {
    var id = event[0].value;
    var name = event[2].innerHTML;
    console.log(id);
    console.log(name);
    var dropMenuspecific = $('.drop-menu-specific');
    dropMenuspecific.hide();
    var specificFriends = $('.specific-users');
    specificFriends.show();
    specificFriends.children('.inner-specific-users').append('<div class="col-lg-4 col-md-6 col-sm-12 mb-0 alert alert-success alert-dismissible fade show" role="alert">' + name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><input type="hidden" name="user_id[]" value="' + id + '" /></div>')

};

$('.make-admin').click(function() {
    var makeAdmin = $(this).children('.user-group');
    if (makeAdmin.text() == 'Member') {
        makeAdmin.text('Admin');
    } else {
        makeAdmin.text('Member');
    }
})

$('.plan-event-btn').click(function() {
    var planEventBtn = $(this).children('#event-show');
    if (planEventBtn.is(":checked")) {
        $(this).siblings('.plan-spots').hide();
        $(this).siblings('#plan-event').show();
    } else {
        $(this).siblings('#plan-event').hide();
        $(this).siblings('.plan-spots').show();
    }
})

function getUserData(e) {
    var likeUser = '';
    $(e).each(function(index2, val) {
        var userData = val['user'];
        if (userData.user_profile) {
            likeUser += '<a href="/people/' + userData.unique_id + '/' + userData.user_slug + '"><img class="rounded-circle mx-1" src="storage/images/user/profile/' + userData.user_profile + '" alt="" width="30" height="30" title="' + userData.fullname + '"></a>'
        } else {
            likeUser += '<a href="/people/' + userData.unique_id + '/' + userData.user_slug + '"><img class="rounded-circle mx-1" src="ibigo-web/images/avatars/2m.png" alt="" width="30" height="30" title="' + userData.fullname + '"></a>'
        }
    })
    return likeUser;
}

function userImg(e) {
    var userImage = '';
    $(e).each(function(index2, val) {
        var userData = val['user'];
        if (userData.user_profile) {
            userImage += '<a href="/people/' + userData.unique_id + '/' + userData.user_slug + '"><img width="30px" title="' + userData.fullname + '" class="fluid-img rounded-circle shadow-xl" src="storage/images/user/profile/' + userData.user_profile + '"></a>';
        } else {
            userImage += '<a href="/people/' + userData.unique_id + '/' + userData.user_slug + '"><img width = "30px" title="' + userData.fullname + '" class = "fluid-img rounded-circle shadow-xl" src = "ibigo-web/images/avatars/2m.png" ></a>';
        }
    });
    return userImage;
}

function groupStatus(e, id) {
    var btn = '<input type="hidden" class="group-id" value="' + id + '" />' +
        '<button type="button" class="btn btn-primary text-light px-3 py-1 join">Join</button>';

    var userId = $('.userId').val();
    $(e).each(function(index, val) {
        if (val.user_id == userId) {
            if (val.group_status == 1) {
                btn = '<input type="hidden" class="group-id" value="' + id + '" />' +
                    '<button type="button" class="btn btn-danger text-light px-3 py-1 cancel">Cancel</button>';

            } else if (val.group_status == 0) {
                btn = '<input type="hidden" class="group-id" value="' + id + '" />' +
                    '<button type="button" class="btn btn-success text-light mr-2 px-3 py-1 confirm">Confirm</button>' +
                    '<button type="button" class="btn btn-danger text-light px-3 py-1 reject">Reject</button>';

            } else if (val.group_status == 3) {
                btn = '<input type="hidden" class="group-id" value="' + id + '" />' +
                    '<button type="button" class="btn btn-warning text-light px-3 py-1 leave">Leave</button>';

            }
        }
    });
    return btn;
}

function friendStatus(e, ee, id) {
    var btn = '<input type="hidden" class="people-id" value="' + id + '" />' +
        '<button type="button" class="btn btn-primary text-light px-3 py-1 add-user">Add Friend</button>';

    var userId = $('.userId').val();
    $(e).each(function(index, val) {
        if (val.from_user_id == userId && val.to_user_id == id) {
            if (val.relation_status == 1) {
                btn = '<input type="hidden" class="people-id" value="' + id + '" />' +
                    '<button type="button" class="btn btn-danger text-light px-3 py-1 unfriend-user">Unfriend</button>';

            } else if (val.relation_status == 0) {
                btn = '<input type="hidden" class="people-id" value="' + id + '" />' +
                    '<button type="button" class="btn btn-warning text-light px-3 py-1 cancel-user">Cancel</button>';
            }
        }
    });
    $(ee).each(function(index, val) {
        if (val.from_user_id == id && val.to_user_id == userId) {
            if (val.relation_status == 1) {
                btn = '<input type="hidden" class="people-id" value="' + id + '" />' +
                    '<button type="button" class="btn btn-danger text-light px-3 py-1 unfriend-user">Unfriend</button>';

            } else if (val.relation_status == 0) {
                btn = '<input type="hidden" class="people-id" value="' + id + '" />' +
                    '<button type="button" class="btn btn-success text-light px-3 mr-2 py-1 accept-user">Accept</button>' +
                    '<button type="button" class="btn btn-warning text-light px-3 py-1 reject-user">Reject</button>';
            }
        }
    });
    return btn;
}

function search(e) {
    var search = $(e).val();
    var searchText = $('.search-text').children('.search-spot-item');
    searchText.children().remove();
    searchText.append('<hr /><h6 class="color-magenta-dark">Search</h6><h1 class="color-dark font-weight-bold font-28">' + search + '</h1>');

    // console.log(search);
    var searchItem = $('.spots-search');
    searchItem.children().remove();
    var body = $('body');
    $.ajax({
        url: "/search-spot",
        type: "GET",
        data: { search: search },
        dataType: 'JSON',
        success: function(res) {
            // console.log(res);
            body.css('opacity', 0.4);
            body.parents().append('<div class="spinner-border color-magenta-dark" role="status"><span class="sr-only">Loading...</span></div>');
            setTimeout(function() {
                    body.css('opacity', 1);
                    body.parents().children('.spinner-border').remove();
                    if (res.spots != '') {
                        searchItem.append('<h1 class="font-30 ml-3">Spots</h1>')
                    }
                    $(res.spots).each(function(index) {
                        // var likeUser = '';
                        var allSpots = '<div class="col-sm-12">' +
                            '<div class="card card-style">' +
                            '<div class="content">' +
                            '<div class="row">' +
                            '<div class="col-sm-2">' +
                            (this.user_spot.user_profile.startsWith('https://') ? '<img width="100%" class="fluid-img rounded-lg shadow-xl" src="' + this.user_spot.user_profile + '">' : '< img width = "100%" class = "fluid-img rounded-lg shadow-xl" src = "storage/images/user/profile/ ' + this.user_spot.user_profile + '">') +
                            '</div>' +
                            '<div class="col-sm-10">' +
                            '<div class="row">' +
                            '<div class="mb-3 col-sm-12">' +
                            '<h2>' + this.business_name + '</h2>' +
                            '<p>' +
                            (this.short_description ? this.short_description.slice(0, 100) : "") +
                            '</p>' +
                            '</div>' +
                            '<div class="d-flex mb-3 col-sm-12">' +
                            '<i class="fas fa-star my-1 " style="color:#000;"></i>' +
                            '<p class="mx-2">Rated ' +
                            (this.rating ? this.rating : 0) +
                            '</p>' +
                            (this.business_type == 'premium' ? '<span class="badge bg-transparent border color-green-dark my-auto ng-star-inserted">premium</span>' : '') +
                            '</div>' +
                            '<div class="col-sm-12">' +
                            '<a class="d-flex" href="https://www.google.com/maps/@' + this.latitude + ',' + this.longitude + '" target="_blank ">' +
                            '<i class="fas fa-map-marker-alt my-1 color-magenta-dark"></i>' +
                            '<p class="color-magenta-dark mx-2">' + this.full_address + '</p>' +
                            '</a>' +
                            '</div>' +
                            '<div class="d-flex mt-3 col-sm-12">' +
                            '<h5 class="my-auto">' +
                            (this.spot_detail[0] ? "Like by :" : "") +
                            '</h5>' +
                            getUserData(this.spot_detail) +
                            '</div>' +

                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<a href="#" data-menu="menu-share3">' +
                            '<div class="go-btn ">' +
                            '<button type="button" class="btn btn-light bg-magenta-dark">+Go</button>' +
                            '</div>' +
                            '</a>' +
                            '</div>';
                        searchItem.append(allSpots);
                    });
                    if (res.groups != '') {
                        searchItem.append('<h1 class="font-30 ml-3">Groups</h1>');
                    }
                    $(res.groups).each(function() {
                        var img = '<img width = "100%" class = "fluid-img rounded-circle shadow-xl" src = "ibigo-web/images/avatars/2m.png" >';
                        if (this.group_profile != null || this.group_profile != undefined) {
                            img = '<img width = "100%" class = "fluid-img rounded-circle shadow-xl" src = "storage/images/group/group_profile/' + this.group_profile + '">';
                        }
                        var count = '';
                        if (this.member_count > 0) {
                            count = '<span>' + this.member_count + ' members of this group</span>';
                        }
                        var allGroups = '<div class="col-sm-12">' +
                            '<div class="card card-style">' +
                            '<div class="content">' +
                            '<div class="row">' +
                            '<div class="col-sm-2">' +
                            img +
                            '</div>' +
                            '<div class="col-sm-10 my-auto">' +
                            '<a href="/groups/' + this.group_unique_id + '/' + this.group_slug + '"><h1>' + this.group_name + '</h1></a>' +
                            '<div>' +
                            userImg(this.members) +
                            count +
                            groupStatus(this.group_status, this.id) +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        searchItem.append(allGroups);
                    });
                    groupAllStatus();

                    if (res.users != '') {
                        searchItem.append('<h1 class="font-30 ml-3">People</h1>');
                    }
                    $(res.users).each(function() {
                        var img = '<img width = "100%" class = "fluid-img rounded-circle shadow-xl" src = "ibigo-web/images/avatars/2m.png" >';
                        if (this.user_profile != null || this.user_profile != undefined) {
                            img = '<img width = "100%" class = "fluid-img rounded-circle shadow-xl" src = "storage/images/user/profile/' + this.user_profile + '">';
                        }
                        var allUsers = '<div class="col-sm-12">' +
                            '<div class="card card-style">' +
                            '<div class="content">' +
                            '<div class="row">' +
                            '<div class="col-sm-2">' +
                            img +
                            '</div>' +
                            '<div class="col-sm-10 my-auto">' +
                            '<a href="/people/' + this.unique_id + '/' + this.user_slug + '"><h1>' + this.first_name + ' ' + this.last_name + '</h1></a>' +
                            '<div>' +
                            friendStatus(this.to, this.from, this.id) +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        searchItem.append(allUsers);
                    });
                    peopleAllStatus();
                },
                2000);
            // alert(res);


        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
}

function peopleAllStatus() {
    var newSearch = $('.search');
    $('.add-user').click(function() {
        var peopleId = $(this).siblings('.people-id').val();
        console.log(peopleId);
        $.ajax({
            url: "/send-request/" + peopleId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });
    $('.unfriend-user').click(function() {
        var peopleId = $(this).siblings('.people-id').val();
        console.log(peopleId);
        $.ajax({
            url: "/unfriend/" + peopleId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });
    $('.reject-user').click(function() {
        var peopleId = $(this).siblings('.people-id').val();
        console.log(peopleId);
        $.ajax({
            url: "/reject-request/" + peopleId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });
    $('.accept-user').click(function() {
        var peopleId = $(this).siblings('.people-id').val();
        console.log(peopleId);
        $.ajax({
            url: "/accept-request/" + peopleId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });
    $('.cancel-user').click(function() {
        var peopleId = $(this).siblings('.people-id').val();
        console.log(peopleId);
        $.ajax({
            url: "/cancel-request/" + peopleId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });
}

function groupAllStatus() {

    var newSearch = $('.search');
    $('.join').click(function() {
        var groupId = $(this).siblings('.group-id').val();
        console.log(groupId);
        $.ajax({
            url: "/user/groups/join/" + groupId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });
    $('.cancel').click(function() {
        var groupId = $(this).siblings('.group-id').val();
        console.log(groupId);
        $.ajax({
            url: "/user/groups/cancel/" + groupId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });
    $('.confirm').click(function() {
        var groupId = $(this).siblings('.group-id').val();
        console.log(groupId);
        $.ajax({
            url: "/user/groups/confirm/" + groupId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });

    $('.reject').click(function() {
        var groupId = $(this).siblings('.group-id').val();
        console.log(groupId);
        $.ajax({
            url: "/user/groups/reject/" + groupId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });
    $('.leave').click(function() {
        var groupId = $(this).siblings('.group-id').val();
        console.log(groupId);
        $.ajax({
            url: "/user/groups/leave/" + groupId,
            type: "GET",
            success: function(res) {
                // console.log(res);
            },
            error: function(request) {
                console.log(JSON.stringify("Error: " + request));
            }
        });
        search(newSearch);
    });
}

$('.search').on('keypress', function(e) {
    if (e.which == 13) {
        // window.location.href = '/search';
        window.history.replaceState({}, '', '/search');
        search(this);
    }
});

$('.show-side-bar').click(function() {
    $('#menu-main').toggleClass('menu-active');
})

$('.close-menu').click(function() {
    $('#menu-main').removeClass('menu-active');
    $('#menu-share3').removeClass('menu-active');
    $('#menu-share1').removeClass('menu-active');
    $('#menu-share-thumbs').removeClass('menu-active');
    $('#menu-share-thumbs2').removeClass('menu-active');
    $('#menu-success-2').css('display', 'none');
});

$('.show-group-modal').click(function() {
    console.log('click');
    $('#menu-share1').toggleClass('menu-active');
});

$('.show-spot-modal').click(function() {
    console.log('click');
    $('#menu-share3').toggleClass('menu-active');
});

$('.show-goto-modal').click(function() {
    console.log('click');
    $('#menu-share-thumbs').toggleClass('menu-active');
});

$('.show-plan-modal').click(function() {
    console.log('click');
    $('#menu-share-thumbs2').toggleClass('menu-active');
});


function groupChat(groupId) {
    var authId = $('.authId').val();
    var chatMsg = $('.group-chat-messgaes');
    chatMsg.children().remove();
    $.ajax({
        url: "/single-group-chat/" + groupId,
        type: "GET",
        dataType: 'JSON',
        success: function(res) {
            $(res.message).each(function(index) {
                if (this.message_date == undefined || this.message_date == '' || this.message_date == null) {
                    var date = '';
                } else {
                    var date = '<p class="font-10 text-center">' + this.message_date + '</p>';
                }
                if (this.user.user_profile == null || this.user.user_profile == undefined || this.user.user_profile == '') {
                    var img = '<img src="../../ibigo-web/images/avatars/2m.png" title="' + this.user.fullname + '" width="30" height="30" class="rounded-circle mr-3">'
                } else {
                    var img = '<img src="storage/images/user/profile/' + this.user.user_profile + '" title="' + this.user.fullname + '" width="30" height="30" class="rounded-circle mr-3">';
                }
                if (this.user_id == authId) {
                    var messages = date + '<div class="d-flex justify-content-end"><div class="speech-bubble speech-left bg-magenta-dark mb-0">' + this.message + '</div></div><div class="clearfix"></div><p class="font-10 text-right">' + this.message_time + '</p>';
                } else {
                    var messages = date + '<div class="d-flex"><div class="my-auto">' + img + '</div><div class="speech-bubble speech-right color-black mb-0">' + this.message + '</div></div><div class="clearfix"></div><p class="font-10 text-left">' + this.message_time + '</p>';
                }
                chatMsg.append(messages + '<div class="clearfix"></div>');

            });
            console.log(res);
        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
    chatMsg.append('<input type="hidden" id="groupId" value="' + groupId + '"  >');
    $(".chat-messgaes").animate({
        scrollTop: $(
            '.chat-messgaes').get(0).scrollHeight
    }, 100);
}

$('.show-group-chat').click(function() {
    var groupId = $(this).children('.groupId').val();
    $('#group-msg-box').show();
    $("#empty-group-msg-box").hide();
    $("#footer-bar").show();
    $('.hide-it').hide();
    groupChat(groupId);
});


$('.msg-btn').click(function() {
    var groupId = $('#groupId').val();
    var msgBox = $(this).parents('.speach-icon').siblings('.flex-fill').children('.msg-box').val();
    $.ajax({
        url: "/group-message-send",
        type: "GET",
        data: { message: msgBox, group_id: groupId },
        dataType: 'JSON',
        success: function(res) {
            console.log(res);
        },
        error: function(request) {
            console.log(JSON.stringify("Error: " + request));
        }
    });
    groupChat(groupId);
    $(this).parents('.speach-icon').siblings('.flex-fill').children('.msg-box').val('');
})