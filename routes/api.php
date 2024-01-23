<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Interest\InterestController;
use App\Http\Controllers\FriendRelation\FriendRelationController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\GroupChat\GroupChatController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\UserGroupRelation\UserGroupRelationController;
use App\Http\Controllers\Spot\SpotController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\SpotDetail\SpotDetailController;
use App\Http\Controllers\BusinessUser\BusinessUserController;
use App\Http\Controllers\GoToList\GoToListController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Planning\PlanningController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\FourSquare\FourSquareController;
use App\Http\Controllers\CMS\CmsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware(['auth:api'])->group(function () {
//     Route::get('/user/logout',[UserController::class,'logout']);

// });

// foursquare routes
Route::get('/foursquare',[UserController::class,'find']);


Route::get('/user/signup-interest',[UserController::class,'getImage']);
Route::get('/get-city',[UserController::class,'getCity']);
// user routes
Route::post('/user/signup',[UserController::class,'signUp']);
Route::post('/user/signup-otp/{uuid}',[UserController::class,'signUpOtp']);
Route::post('/user/signup-validate',[UserController::class,'validateUser']);
Route::post('/user/check-mail',[UserController::class,'checkMail']);
Route::get('/user/verify/{token}',[UserController::class,'verifyUser']);
Route::post('/user/login',[UserController::class,'login']);
Route::post('/user/mobile-login',[UserController::class,'mobileLogin']);
Route::post('/user/forgot-password', [UserController::class,'forgotPassword']);
Route::post('/user/reset/{token}',[UserController::class,'reset']);
// business user routes
Route::post('/user/business/register',[BusinessUserController::class,'store']);
Route::post('/user/business/login',[BusinessUserController::class,'create']);

// facebook login route
Route::post('/facebook/login',[UserController::class,'facebookLogin']);

// payment routes
Route::match(array('GET','POST'),'webhook/redirect',[BusinessUserController::class,'getPayment']);
Route::match(array('GET','POST'),'webhook/redirect1',[BusinessUserController::class,'mailTestFor']);

Route::group(['middleware'=>'auth:api'],function(){
    // user routes
    Route::get('/user/status',[UserController::class,'loggedInOrNot']);
    Route::get('/user',[UserController::class,'index']);
    Route::post('/user-status',[UserController::class,'checkUserLoggedInOrNot']);
    Route::get('/user-list',[UserController::class,'get']);
    Route::get('/user/profile',[UserController::class,'show']);
    Route::post('/user/update-profile',[UserController::class,'updateUser']);
    Route::post('/user/update-profile-cover',[UserController::class,'updatePictures']);
    Route::post('/user/update-interests',[UserController::class,'updateInterest']);
    Route::post('/user/verify',[UserController::class,'verify']);
    Route::post('/user/change-password',[UserController::class,'changePassword']);
    Route::post('/user/update-about',[UserController::class,'updateAbout']);
    Route::get('/user/delete',[UserController::class,'destroy']);
    Route::get('/user/people/{id}',[UserController::class,'userProfile']);
    Route::post('/user/follow',[UserController::class,'userFollow']);
    Route::get('/user/followers',[UserController::class,'followers']);
    Route::get('/user/followings',[UserController::class,'followings']);

    // business user routes
    Route::get('/user/business/profile',[BusinessUserController::class,'show']);
    Route::post('/user/business/update',[BusinessUserController::class,'update']);
    Route::post('/user/business/update-pictures',[BusinessUserController::class,'updateProfileCover']);

    // friends-relation routes
    Route::get('/user/friend-request',[FriendRelationController::class,'friendRequest']);
    Route::get('/user/friend-suggestion',[FriendRelationController::class,'index']);
    Route::post('/user/send-request',[FriendRelationController::class,'sendRequest']);
    Route::post('/user/accept-request/{id}',[FriendRelationController::class,'acceptRequest']);
    Route::post('/user/reject-request/{id}',[FriendRelationController::class,'rejectRequest']);
    Route::post('/user/cancel-request/{id}',[FriendRelationController::class,'cancelRequest']);
    Route::post('/user/unfriend/{id}',[FriendRelationController::class,'unfriend']);
    Route::post('/user/block/{id}',[FriendRelationController::class,'block']);
    Route::post('/user/unblock/{id}',[FriendRelationController::class,'unblock']);
    Route::get('/user/friends-list',[FriendRelationController::class,'friendList']);
    Route::get('/user/friends-connected/{id}',[FriendRelationController::class,'show']);
    Route::get('/user/friend-suggestion',[FriendRelationController::class,'friendSuggestion']);
    Route::post('/user/search-friends',[FriendRelationController::class,'searchFriends']);

    // interests routes

    Route::get('/user/interest',[InterestController::class,'index']);
    Route::post('/user/interest/add',[InterestController::class,'store']);
    Route::get('/user/interest/show/{id}',[InterestController::class,'edit']);
    Route::post('/user/interest/update/{id}',[InterestController::class,'update']);
    Route::get('/user/interest/delete/{id}',[InterestController::class,'destroy']);

    //  filters route
    Route::get('/user/filters',[InterestController::class,'show']);

    // group routes
    Route::post('/user/group/create',[GroupController::class,'store']);
    Route::get('/user/group',[GroupController::class,'index']);
    Route::get('/user/group/{id}',[GroupController::class,'show']);
    Route::get('/user/user-groups',[GroupController::class,'userGroup']);
    Route::post('/user/group/{id}',[GroupController::class,'update']);
    Route::get('/user/user-group/delete/{id}',[GroupController::class,'destroy']);
    Route::get('/user/group-or-user/{id}',[GroupController::class,'groupOrUser']);
    Route::post('/user/search-group',[GroupController::class,'searchGroup']);

    Route::get('/user/groups/invite-list/{groupId}',[UserGroupRelationController::class,'index']);
    Route::post('/user/groups/invite/{groupId}',[UserGroupRelationController::class,'sendInvitation']);
    Route::post('/user/groups/confirm/{groupId}',[UserGroupRelationController::class,'confirmInvitation']);
    Route::post('/user/groups/reject/{groupId}',[UserGroupRelationController::class,'rejectInvitation']);
    Route::post('/user/groups/join/{groupId}',[UserGroupRelationController::class,'joinRequest']);
    Route::post('/user/groups/accept/{groupId}',[UserGroupRelationController::class,'acceptRequest']);
    Route::post('/user/groups/cancel/{groupId}',[UserGroupRelationController::class,'cancelRequest']);
    Route::post('/user/groups/leave/{groupId}',[UserGroupRelationController::class,'leaveGroup']);
    Route::post('/user/groups/remove/{groupId}',[UserGroupRelationController::class,'removeMember']);
    Route::post('/user/groups/admin-or-not/{groupId}',[UserGroupRelationController::class,'makeAdmin']);
    Route::get('/user/groups/pending-invite',[UserGroupRelationController::class,'pendingInvitation']);

    //group chat routes
    Route::get('/user/group-chats',[GroupChatController::class,'index']);
    Route::post('/user/group-chats/create/{groupId}',[GroupChatController::class,'store']);
    Route::get('/user/group-chats/show/{groupId}',[GroupChatController::class,'show']);
    Route::get('/user/group-chats/destroy/{messageId}',[GroupChatController::class,'destroy']);
    Route::get('/user/group-chats/delete/{groupId}',[GroupChatController::class,'delete']);

    // event routes
    Route::get('/user/event',[EventController::class,'index']);
    Route::post('/user/event/create',[EventController::class,'store']);
    Route::get('/user/event/{id}',[EventController::class,'show']);
    Route::post('/user/event/{id}',[EventController::class,'update']);
    Route::post('/user/event/cover/{id}',[EventController::class,'edit']);
    Route::get('/user/events/delete/{id}',[EventController::class,'destroy']);
    Route::post('/user/event-invite/{id}',[EventController::class,'invite']);
    Route::post('/user/event-connected/{id}',[EventController::class,'connected']);

    // post routes
    Route::get('/user/load-posts',[PostController::class,'index']);
    Route::post('/user/post/create',[PostController::class,'store']);
    Route::get('/user/post/show/{id}',[PostController::class,'show']);
    Route::post('/user/post/edit/{id}',[PostController::class,'update']);
    Route::get('/user/post/delete/{id}',[PostController::class,'destroy']);
    Route::post('/user/post/like/{id}',[PostController::class,'likePost']);
    Route::post('/user/post/comment/{id}',[PostController::class,'commentPost']);
    Route::post('/user/post/comment/update/{id}',[PostController::class,'updateCommentPost']);
    Route::get('/user/post/comment/delete/{id}',[PostController::class,'deleteCommentPost']);
    Route::get('/user/user-post',[PostController::class,'userPost']);
    Route::get('/user/checkin-post',[PostController::class,'checkinPost']);
    Route::get('/user/group-post',[PostController::class,'groupPost']);
    Route::get('/user/spot-post',[PostController::class,'spotPost']);
    Route::get('/user/recent-user',[PostController::class,'recentUser']);
    Route::get('/user/share-post/{id}',[PostController::class,'sharePost']);
    Route::post('/user/share-edit-post/{id}',[PostController::class,'shareUpdatePost']);
    Route::get('/user/dashboard-posts/{take}',[PostController::class,'allPost']);
    Route::post('/user/share-post-in-groups/{id}',[PostController::class,'sharePostInGroup']);
    Route::get('/user/group-post/{id}',[PostController::class,'allGroupPost']);

    // spot review routes
    Route::post('/user/spot/create/{id}',[SpotDetailController::class,'store']);
    Route::post('/user/spot/upload-media/{id}',[SpotDetailController::class,'uploadMedia']);
    Route::post('/user/spot/edit/{id}',[SpotDetailController::class,'update']);
    Route::get('/user/spot/delete/{id}',[SpotDetailController::class,'destroy']);
    Route::post('/user/spot/like/{id}',[SpotDetailController::class,'like']);
    Route::post('/user/spot/connected/{id}',[SpotDetailController::class,'connected']);
    Route::post('/user/spot/invite-friends/{id}',[SpotDetailController::class,'invite']);
    Route::post('/user/spot-reply/create/{id}',[SpotDetailController::class,'storeReply']);
    Route::post('/user/spot-reply/edit/{id}',[SpotDetailController::class,'updateReply']);
    Route::get('/user/spot-reply/delete/{id}',[SpotDetailController::class,'destroyReply']);

    // spot routes
    Route::get('/user/spot',[SpotController::class,'index']);
    Route::post('/user/search-spot',[SpotController::class,'search']);
    Route::get('/user/single-spot/{id}',[SpotController::class,'show']);
    Route::get('/user/user-spot',[SpotDetailController::class,'index']);
    Route::get('/top-rated-spot',[SpotController::class,'topRated']);

    // gotolist routes
    Route::get('/user/go-to-list',[GoToListController::class,'index']);
    Route::post('/user/go-to-list/create',[GoToListController::class,'store']);
    Route::get('/user/go-to-list/show/{id}',[GoToListController::class,'show']);
    Route::post('/user/go-to-list/edit/{id}',[GoToListController::class,'update']);
    Route::post('/user/go-to-list/like/{id}',[GoToListController::class,'likeGoTo']);
    Route::get('/user/go-to-list/spots',[GoToListController::class,'getOtherSpots']);
    Route::get('/user/go-to-list/delete/{id}',[GoToListController::class,'destroy']);

    // search route
    Route::post('/user/search',[SearchController::class,'store']);
    Route::post('/user/search-with-filters',[SearchController::class,'search']);

    // planning routes
    Route::get('/user/planning',[PlanningController::class,'index']);
    Route::post('/user/planning/create',[PlanningController::class,'store']);
    Route::get('/user/calender-events',[PlanningController::class,'show']);
    Route::post('/user/share-planning',[PlanningController::class,'update']);
    Route::post('/user/planning/send-invitation/{id}',[PlanningController::class,'sendInvitation']);
    Route::post('/user/planning/accept-invitation/{id}',[PlanningController::class,'acceptInvitation']);
    Route::post('/user/planning/reject-invitation/{id}',[PlanningController::class,'rejectInvitation']);
    Route::get('/user/planning/pending-invitation/{id}',[PlanningController::class,'invitationPending']);

    // chat routes
    Route::get('/user/chats/{id}',[ChatController::class,'show']);
    Route::post('/user/chat/create/{id}',[ChatController::class,'store']);
    Route::get('/user/chat/recent',[ChatController::class,'index']);
    Route::get('/user/chat/recent-friends',[ChatController::class,'friends']);
    Route::post('/user/chat/read-message/{id}',[ChatController::class,'read']);
    Route::post('/user/chat/unread-message/{id}',[ChatController::class,'unread']);
    Route::get('/user/chat/delete/{id}',[ChatController::class,'destroy']);

    // notification routes
    Route::get('/user/notifications',[SearchController::class,'index']);
    Route::post('/user/notification-status/{id}',[SearchController::class,'update']);
    Route::get('/user/notification/delete/{id}',[SearchController::class,'destroy']);
    Route::get('/user/notification/count',[SearchController::class,'show']);
    Route::post('/user/notification/count-update',[SearchController::class,'updateCount']);

    // spot suggestions route
    Route::post('/user/spot-suggestion',[SearchController::class,'create']);

    // page routes
    Route::get('/user/pages',[PageController::class,'index']);
    Route::get('/user/page/{id}',[PageController::class,'show']);

    // all active expertise
    Route::get('/expertise',[SearchController::class,'allExpertise']);

    // all cms
    Route::get('/cms',[CmsController::class,'index']);
    Route::get('/cms/{id}',[CmsController::class,'show']);

    // logout route
    Route::get('/user/logout',[UserController::class,'logout']);
});

