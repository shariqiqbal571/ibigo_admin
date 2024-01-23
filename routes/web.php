<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Admin\RolePermission\RolePermissionController;
use App\Http\Controllers\Admin\Permission\PermissionController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Interest\InterestController;
use App\Http\Controllers\Admin\Spot\SpotController;
use App\Http\Controllers\Admin\Event\EventController;
use App\Http\Controllers\Admin\Page\PageController;
use App\Http\Controllers\Admin\Group\GroupController;
use App\Http\Controllers\Admin\Filter\FilterController;
use App\Http\Controllers\Admin\Post\PostController;
use App\Http\Controllers\Admin\CheckInPost\CheckInPostController;
use App\Http\Controllers\Admin\GroupPost\GroupPostController;
use App\Http\Controllers\Admin\SpotPost\SpotPostController;
use App\Http\Controllers\Admin\SpotReview\SpotReviewController;
use App\Http\Controllers\Admin\Expertise\ExpertiseController;
use App\Http\Controllers\Admin\CMS\CmsController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\SocialAuthFacebookController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserGroupRelation\UserGroupRelationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('admin/login');
// });

//just for check page is working or not




Route::group(['middleware' => ['auth-login']],function(){
  Route::get('/admin/login',[AdminController::class,'login'])->name('admin/login');
  Route::post('/check-user',[AdminController::class,'loginCheck'])->name('check-user');
});


Route::group(['middleware'=>['auth-admin']],function()
{
    Route::get('/admin',[UserController::class,'adminLayout'])->name('admin');
    //Route::get('/',[UserController::class,'adminLayout'])->name('');

    //Route Roles
    Route::get('/admin/role',[RoleController::class,'index']);
    Route::get('/admin/role/add',[RoleController::class,'create']);
    Route::post('/admin/role/store',[RoleController::class,'store']);
    Route::get('/admin/role/view/{id}',[RoleController::class,'show']);
    Route::get('/admin/role/edit/{id}',[RoleController::class,'edit']);
    Route::put('/admin/role/update/{id}',[RoleController::class,'update']);
    Route::get('/admin/role/delete/{id}',[RoleController::class,'destroy']);

    //Route Roles_Permission

    Route::get('/admin/role_permission',[RolePermissionController::class,'index']);
    Route::get('/admin/role_permission/add',[RolePermissionController::class,'create']);
    Route::post('/admin/role_permission/store',[RolePermissionController::class,'store']);
    Route::get('/admin/role_permission/view/{id}',[RolePermissionController::class,'show']);
    Route::get('/admin/role_permission/edit/{id}',[RolePermissionController::class,'edit']);
    Route::put('/admin/role_permission/update/{id}',[RolePermissionController::class,'update']);
    Route::get('/admin/role_permission/delete/{id}',[RolePermissionController::class,'destroy']);

    //Route Permission

    Route::get('/admin/permission',[PermissionController::class,'index']);

    //Route User

    Route::get('/admin/user',[UserController::class,'index']);
    Route::get('/admin/user/add',[UserController::class,'create']);
    Route::post('/admin/user/store',[UserController::class,'store']);
    Route::get('/admin/user/view/{id}',[UserController::class,'show']);
    Route::get('/admin/user/edit/{id}',[UserController::class,'edit']);
    Route::put('/admin/user/update/{id}',[UserController::class,'update']);
    Route::get('/admin/user/delete/{id}',[UserController::class,'destroy']);



    //Route Profile

    Route::get('/admin/profile',[ProfileController::class,'index']);
    // Route::get('/admin/profile/add',[ProfileController::class,'create']);
    // Route::post('/admin/profile/store',[ProfileController::class,'store']);
    // Route::get('/admin/profile/view/{id}',[ProfileController::class,'show']);
    // Route::get('/admin/profile/edit/{id}',[ProfileController::class,'edit']);
    Route::put('/admin/profile/update/{id}',[ProfileController::class,'update']);
    // Route::get('/admin/profile/delete/{id}',[ProfileController::class,'destroy']);


    //Route profile password
    // Route::post('/admin/profile/add',[ProfileController::class,'profileadd']);
    Route::get('/admin/profile/password/',[ProfileController::class,'password']);
    Route::put('/admin/profile/password/update/{id}',[ProfileController::class,'updatepassword']);



    //Route Admin admin-users

    Route::get('/admin/admin-users',[AdminController::class,'index']);
    Route::get('/admin/admin-users/add',[AdminController::class,'create']);
    Route::post('/admin/admin-users/store',[AdminController::class,'store']);
    Route::get('/admin/admin-users/view/{id}',[AdminController::class,'show']);
    Route::get('/admin/admin-users/edit/{id}',[AdminController::class,'edit']);
    Route::put('/admin/admin-users/update/{id}',[AdminController::class,'update']);
    Route::get('/admin/admin-users/delete/{id}',[AdminController::class,'destroy']);


    //Route Interest

    Route::get('/admin/interest',[InterestController::class,'index']);
    Route::get('/admin/interest/add',[InterestController::class,'create']);
    Route::post('/admin/interest/store',[InterestController::class,'store']);
    Route::get('/admin/interest/view/{id}',[InterestController::class,'show']);
    Route::get('/admin/interest/edit/{id}',[InterestController::class,'edit']);
    Route::put('/admin/interest/update/{id}',[InterestController::class,'update']);
    Route::get('/admin/interest/delete/{id}',[InterestController::class,'destroy']);

     //Route spot

     Route::get('/admin/spot',[SpotController::class,'index']);
     Route::get('/admin/spot/add',[SpotController::class,'create']);
     Route::post('/admin/spot/store',[SpotController::class,'store']);
     Route::get('/admin/spot/view/{id}',[SpotController::class,'show']);
     Route::get('/admin/spot/edit/{id}',[SpotController::class,'edit']);
     Route::put('/admin/spot/update/{id}',[SpotController::class,'update']);
     Route::get('/admin/spot/delete/{id}',[SpotController::class,'destroy']);

      //Route Event

      Route::get('/admin/event',[EventController::class,'index']);
      Route::get('/admin/event/add',[EventController::class,'create']);
      Route::post('/admin/event/store',[EventController::class,'store']);
    //Route::get('/admin/event/view/{id}',[EventController::class,'show']);
      Route::get('/admin/event/edit/{id}',[EventController::class,'edit']);
      Route::put('/admin/event/update/{id}',[EventController::class,'update']);
      Route::get('/admin/event/delete/{id}',[EventController::class,'destroy']);

       //Route Page

       Route::get('/admin/page',[PageController::class,'index']);
       Route::get('/admin/page/add',[PageController::class,'create']);
       Route::post('/admin/page/store',[PageController::class,'store']);
      //Route::get('/admin/page/view/{id}',[PageController::class,'show']);
       Route::get('/admin/page/edit/{id}',[PageController::class,'edit']);
       Route::put('/admin/page/update/{id}',[PageController::class,'update']);
       Route::get('/admin/page/delete/{id}',[PageController::class,'destroy']);


        //Route Group

        Route::get('/admin/group',[GroupController::class,'index']);
        Route::get('/admin/group/view/{id}',[GroupController::class,'show']);

        //Route Filters
        Route::get('/admin/filters',[FilterController::class,'index']);
        Route::get('/admin/filters/add',[FilterController::class,'create']);
        Route::post('/admin/filters/store',[FilterController::class,'store']);
        Route::get('/admin/filters/view/{id}/{slug}',[FilterController::class,'show']);
        Route::get('/admin/filters/edit/{id}/{slug}',[FilterController::class,'edit']);
        Route::put('/admin/filters/update/{id}',[FilterController::class,'update']);
        Route::get('/admin/filters/delete/{id}',[FilterController::class,'destroy']);

        //Route Expertise
        Route::get('/admin/expertise',[ExpertiseController::class,'index']);
        Route::get('/admin/expertise/add',[ExpertiseController::class,'create']);
        Route::post('/admin/expertise/store',[ExpertiseController::class,'store']);
        Route::get('/admin/expertise/view/{id}/{slug}',[ExpertiseController::class,'show']);
        Route::get('/admin/expertise/edit/{id}/{slug}',[ExpertiseController::class,'edit']);
        Route::put('/admin/expertise/update/{id}',[ExpertiseController::class,'update']);
        Route::get('/admin/expertise/delete/{id}',[ExpertiseController::class,'destroy']);
        //Route Post

        Route::get('/admin/post',[PostController::class,'index']);
        Route::get('/admin/post/view/{unique}/{id}',[PostController::class,'show']);
        Route::get('/admin/post/delete/{id}',[PostController::class,'destroy']);
        Route::get('/admin/post/comment/delete/{id}',[PostController::class,'commentDelete']);



        //Route checkin-post

        Route::get('/admin/checkin-post',[CheckInPostController::class,'index']);
        Route::get('/admin/checkin-post/view/{unique}/{id}',[CheckInPostController::class,'show']);
        Route::get('/admin/checkin-post/delete/{id}',[CheckInPostController::class,'destroy']);
        Route::get('/admin/checkin-post/comment/delete/{id}',[CheckInPostController::class,'commentDelete']);


        //Route Group-post

        Route::get('/admin/group-post',[GroupPostController::class,'index']);
        Route::get('/admin/group-post/view/{unique}/{id}',[GroupPostController::class,'show']);
        Route::get('/admin/group-post/delete/{id}',[GroupPostController::class,'destroy']);
        Route::get('/admin/group-post/comment/delete/{id}',[GroupPostController::class,'commentDelete']);


        //Route Spot-post

        Route::get('/admin/spot-post',[SpotPostController::class,'index']);
        Route::get('/admin/spot-post/view/{unique}/{id}',[SpotPostController::class,'show']);
        Route::get('/admin/spot-post/delete/{id}',[SpotPostController::class,'destroy']);
        Route::get('/admin/spot-post/comment/delete/{id}',[SpotPostController::class,'commentDelete']);

        //Route Spot-review

        Route::get('/admin/reviews',[SpotReviewController::class,'index']);
        Route::get('/admin/reviews/view/{unique}/{id}',[SpotReviewController::class,'show']);
        Route::get('/admin/reviews/delete/{id}',[SpotReviewController::class,'destroy']);

        //Route CMS

        Route::get('/admin/cms',[CmsController::class,'index']);
        Route::get('/admin/cms/edit/{id}/{slug}',[CmsController::class,'edit']);
        Route::post('/admin/cms/update/{id}',[CmsController::class,'update']);


        Route::get('/admin/cms-detail',[CmsController::class,'get']);
        Route::get('/admin/cms-detail/show/{id}/{slug}',[CmsController::class,'show']);
        Route::get('/admin/cms-detail/edit/{id}/{slug}',[CmsController::class,'editDetail']);
        Route::post('/admin/cms-detail/create/{id}',[CmsController::class,'store']);
        Route::post('/admin/cms-detail/update/{id}',[CmsController::class,'updateDetail']);
        Route::get('/admin/cms-detail/delete/{id}',[CmsController::class,'destroy']);
        Route::get('/delete-image/{id}',[CmsController::class,'delete']);

    // route logout
    Route::get('/logout',[AdminController::class,'logout'])->name('admin.logout');

});


Route::get('/redirect', [SocialAuthFacebookController::class,'redirect'])->name('facebook-redirect');
Route::get('/callback', [SocialAuthFacebookController::class,'callback'])->name('facebook-callback');
Route::get('/privacy-policy', function(){
return [];
});



Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('');

// ajax routes
// post routes
Route::post('/web/post/store',[CheckController::class,'store']);
Route::post('/upload-cover',[CheckController::class,'uploadCover']);
Route::get('/single-chat/{id}',[CheckController::class,'getSingleChat']);
Route::get('/single-group-chat/{id}',[CheckController::class,'getSingleGroupChat']);
Route::get('/message-send',[CheckController::class,'messageSend']);
Route::get('/group-message-send',[CheckController::class,'groupMessageSend']);

// search routes
Route::get('/search-spot',[CheckController::class,'searchSpots']);
Route::get('/web/search',[CheckController::class,'searchInput']);
Route::get('/findspot/{id}',[CheckController::class,'findSpot']);
Route::get('/find-friends',[CheckController::class,'findFriends']);
Route::post('/change-interest/{id}',[CheckController::class,'changeUserInterest']);
Route::get('/notification-status/{id}',[CheckController::class,'updateNotiStatus']);
Route::get('/information/{id}',[CheckController::class,'informationPages']);

// end ajax routes


//web user routes
Route::post('/password/edit',[CheckController::class,'passwordStore']);
Route::post('/ibigo-web/update/{id}',[CheckController::class,'updateUserProfile']);


// ibigo web routes
Route::get('/check',[CheckController::class,'index']);
Route::get('/spots/{id}/{slug}',[CheckController::class,'singleSpot']);
Route::get('/spot-review/{id}/{slug}',[CheckController::class,'spotReview']);
Route::get('/profile',[CheckController::class,'profile']);
Route::get('/interest',[CheckController::class,'profile']);
Route::get('/notifications',[CheckController::class,'profile']);
Route::get('/update-profile',[CheckController::class,'updateProfile']);
Route::get('/event/{id}/{slug}',[CheckController::class,'testing']);
Route::get('/people/{id}/{slug}',[CheckController::class,'people']);
Route::get('/user-review/{id}/{slug}',[CheckController::class,'userReview']);
Route::get('/friends',[CheckController::class,'friendsGroupsSpots']);
Route::get('/groups',[CheckController::class,'friendsGroupsSpots']);
Route::get('/spots',[CheckController::class,'friendsGroupsSpots']);
Route::get('/pages/{id}/{slug}',[CheckController::class,'pages']);
Route::get('/chat',[CheckController::class,'chat']);
Route::get('/search',[CheckController::class,'spots']);
Route::get('/todo/go-list',[CheckController::class,'plan']);
Route::get('/todo/plan',[CheckController::class,'plan']);
Route::get('/mobile',[CheckController::class,'mobile']);
Route::get('/groups/{id}/{slug}',[CheckController::class,'singleGroup']);

Route::post('/create-group',[CheckController::class,'createGroup']);
Route::post('/create-go-to',[CheckController::class,'createGoTo']);
Route::post('/create-plan',[CheckController::class,'createPlan']);
Route::post('/create-event',[CheckController::class,'createEvent']);
Route::post('/make-member/{id}',[CheckController::class,'makeRejectMember']);
Route::post('/reject-member/{id}',[CheckController::class,'makeRejectMember']);

Route::get('/send-request/{id}',[CheckController::class,'send']);
Route::get('/cancel-request/{id}',[CheckController::class,'cancel']);
Route::get('/reject-request/{id}',[CheckController::class,'reject']);
Route::get('/accept-request/{id}',[CheckController::class,'accept']);
Route::get('/unfriend/{id}',[CheckController::class,'unfriend']);

Route::get('/like-spot/{id}',[CheckController::class,'likeSpot']);
Route::get('/connected-spot/{id}',[CheckController::class,'connectedSpot']);

Route::get('/group-chat',[CheckController::class,'groupChat']);

Route::get('/user/groups/join/{groupId}',[UserGroupRelationController::class,'joinRequest']);
Route::get('/user/groups/leave/{groupId}',[UserGroupRelationController::class,'leaveGroup']);
Route::get('/user/groups/cancel/{groupId}',[UserGroupRelationController::class,'cancelRequest']);
Route::get('/user/groups/reject/{groupId}',[UserGroupRelationController::class,'rejectInvitation']);
Route::get('/user/groups/confirm/{groupId}',[UserGroupRelationController::class,'confirmInvitation']);


//